<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
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

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // 1. [KEAMANAN] Validasi Signature Key
        // Menggabungkan order_id + status_code + gross_amount + Server Key
        // Pastikan Anda sudah menyimpan Server Key di config Laravel Anda
        $serverKey = config('services.midtrans.server_key'); // Sesuaikan dengan lokasi config Anda
        $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $calculatedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Mencari ID transaksi di database lokal
        $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 3. Cegah proses berulang jika status sudah lunas/sukses
        if (in_array($transaction->status, ['settlement', 'success'])) {
            return response()->json(['message' => 'Already processed'], 200);
        }

        // 4. Logika Penerjemahan Status Midtrans API
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->status = 'settlement';
            $this->processSuccess($transaction);
        } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->save();

        return response()->json(['message' => 'OK'], 200);
    }

    private function processSuccess(Transaction $transaction)
    {
        // Masukkan logika setelah sukses di sini
        // Contoh: Mengirim email tiket, mengurangi stok, dll.
    }
}