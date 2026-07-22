<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Mail\EventTicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = \App\Models\Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $orderId    = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price == 0 ? 0 : ($event->price + 5000);

        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'Pending',
        ]);

        // Penanganan Khusus Tiket Gratis (Tanpa Midtrans)
        if ($event->price == 0) {
            $transaction->update(['status' => 'success']);
            $event->decrement('stock');

            try {
                Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
                Log::info('E-Ticket email sent for free event to: ' . $transaction->customer_email);
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email E-Ticket gratis: ' . $e->getMessage());
            }

            return redirect()->route('checkout.success', $transaction->order_id);
        }

        // --- INTEGRASI SNAP MIDTRANS ---
        // Konfigurasi Kredensial Environment Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key') ?? config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false; // Mode Sandbox!
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Susun Paket Array Data Transaksi
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone,
            ],
        ];

        try {
            // Perintah Tembak Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            // Update rekaman kita bahwa transaksi terkait sudah memiliki id token pelunasan
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman antarmuka pembayaran final pelanggan
            return redirect()->route('checkout.payment', $transaction->order_id);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

    public function payment(string $order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction','categories'));
    }

    public function success(string $order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        // Validasi status pembayaran asli dari Midtrans (Mencegah manipulasi URL)
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key') ?? config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;

        try {
            $midtransStatus = \Midtrans\Transaction::status($order_id);

            // Hanya ubah status menjadi sukses jika Midtrans mengonfirmasi pembayaran lunas
            if (in_array($midtransStatus->transaction_status, ['capture', 'settlement'])) {
                $isNewSuccess = strtolower($transaction->status) !== 'success' && strtolower($transaction->status) !== 'settlement';
                
                if ($isNewSuccess) {
                    $transaction->update(['status' => 'success']);
                    
                    // Kurangi stok jika belum berkurang via webhook
                    if ($transaction->event && $transaction->event->stock > 0) {
                        $transaction->event->decrement('stock');
                    }

                    // Kirim E-Ticket email
                    try {
                        Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
                        Log::info('E-Ticket email sent on success page to: ' . $transaction->customer_email);
                    } catch (\Exception $e) {
                        Log::error('Gagal mengirim email E-Ticket pada success page: ' . $e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika error (transaksi tidak ada di Midtrans, koneksi terputus), kembalikan ke beranda
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction','categories'));
    }
}