<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Mail\EventTicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Transaction as MidtransTransaction;

class MidtransWebhookController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key') ?? config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = config('services.midtrans.is_production') ?? config('midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Handle webhook dari Midtrans
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        
        // Data yang dibutuhkan untuk validasi keamanan
        $signatureKey = $payload['signature_key'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;

        // 1. Validasi Order ID
        if (!$orderId) {
            Log::warning('Webhook received with invalid payload');
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // 2. [KEAMANAN] Validasi Signature Key
        $serverKey = config('services.midtrans.server_key') ?? config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $calculatedSignature) {
            Log::warning('Invalid signature for order: ' . $orderId);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 3. Mencari transaksi di database lokal
        $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

        if (!$transaction) {
            Log::warning('Transaction not found for order: ' . $orderId);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 4. Cegah proses berulang jika status sudah lunas/sukses
        if (in_array($transaction->status, ['settlement', 'success'])) {
            Log::info('Transaction already processed: ' . $orderId);
            return response()->json(['message' => 'Already processed'], 200);
        }

        // 5. Logika Penerjemahan Status Midtrans API
        $oldStatus = $transaction->status;
        
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            } elseif ($fraudStatus == 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->status = 'settlement';
            $this->processSuccess($transaction);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        } elseif ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->save();

        Log::info('Transaction status updated from ' . $oldStatus . ' to ' . $transaction->status . ' for order: ' . $orderId);

        return response()->json(['message' => 'OK'], 200);
    }

    /**
     * Tampilkan halaman sukses pembayaran
     *
     * @param string $order_id
     */
    public function success(string $order_id)
    {
        // Validasi order_id format
        if (empty($order_id) || !is_string($order_id)) {
            Log::warning('Invalid order_id format: ' . $order_id);
            return redirect()->route('home')->with('error', 'Order ID tidak valid.');
        }

        try {
            // Mengambil transaksi dari database
            $transaction = Transaction::with('event')
                ->where('order_id', $order_id)
                ->firstOrFail();

            // Cek status transaksi ke Midtrans API
            $this->verifyTransactionWithMidtrans($transaction);

            // Mengambil daftar kategori untuk menu
            $categories = Category::all();

            return view('checkout.success', compact('transaction', 'categories'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Transaction not found for order_id: ' . $order_id);
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error in success page: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat memproses transaksi.');
        }
    }

    /**
     * Verifikasi status transaksi ke Midtrans API (Fallback jika webhook gagal)
     */
    private function verifyTransactionWithMidtrans(Transaction $transaction)
    {
        try {
            // Cek status ke API Midtrans
            $status = MidtransTransaction::status($transaction->order_id);
            $trxStatus = $status->transaction_status ?? null;

            // Jika API Midtrans mengonfirmasi transaksi berhasil
            if (in_array($trxStatus, ['settlement', 'capture'])) {
                // Hanya proses jika status di database masih 'pending'
                if (strtolower($transaction->status) === 'pending') {
                    $transaction->status = 'success';
                    $transaction->save();
                    
                    Log::info('Transaction verified from Midtrans API for order: ' . $transaction->order_id);
                    
                    // Proses post-payment success
                    $this->processSuccess($transaction);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to verify transaction with Midtrans: ' . $e->getMessage());
            // Jangan throw error, biarkan user melihat halaman sukses
            // karena transaksi sudah ada di database
        }
    }

    /**
     * Proses setelah pembayaran sukses
     */
    private function processSuccess(Transaction $transaction)
    {
        $event = $transaction->event;

        // Validasi event
        if (!$event) {
            Log::error('Event not found for transaction: ' . $transaction->id);
            return;
        }

        // Kurangi stok tiket
        if ($event->stock > 0) {
            $event->stock--;
            $event->save();

            Log::info('Stock decreased for event: ' . $event->id . '. Remaining stock: ' . $event->stock);
        } else {
            Log::warning('Stock habis untuk event: ' . $event->id . ' (Order: ' . $transaction->order_id . ')');
            // TODO: Implementasikan logika refund otomatis jika diperlukan
            return;
        }

        // Kirim email E-Ticket
        $this->sendTicketEmail($transaction);
    }

    /**
     * Kirim email E-Ticket dengan error handling
     */
    private function sendTicketEmail(Transaction $transaction)
    {
        try {
            Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
            Log::info('E-Ticket email sent to: ' . $transaction->customer_email . ' (Order: ' . $transaction->order_id . ')');
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email E-Ticket untuk order ' . $transaction->order_id . ': ' . $e->getMessage());
            // Email gagal, tapi jangan batalkan proses pembayaran
        }
    }
}