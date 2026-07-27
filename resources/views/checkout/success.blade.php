@extends('layouts.app')

@section('title', 'Pembayaran & Pemesanan Berhasil')

@section('content')
<main class="max-w-2xl mx-auto px-6 py-16 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-8 md:p-12 shadow-xl space-y-6">
        <!-- Success Check Icon -->
        <div class="w-24 h-24 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <div>
            <span class="px-3.5 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold uppercase tracking-wider">
                Transaksi Lunas & Berhasil
            </span>
            <h2 class="text-3xl font-black text-slate-900 mt-3">Terima Kasih, {{ $transaction->customer_name }}!</h2>
            <p class="text-slate-500 text-sm mt-1">
                Pemesanan tiket Anda untuk event <strong>{{ $transaction->event->title }}</strong> telah dikonfirmasi.
            </p>
        </div>

        <!-- Receipt Card -->
        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-left space-y-3">
            <div class="flex justify-between text-xs font-semibold text-slate-500">
                <span>ORDER ID</span>
                <span class="font-mono text-slate-900 font-bold">{{ $transaction->order_id }}</span>
            </div>
            <div class="flex justify-between text-xs font-semibold text-slate-500">
                <span>EMAIL PENERIMA</span>
                <span class="text-slate-900 font-bold">{{ $transaction->customer_email }}</span>
            </div>
            <div class="flex justify-between text-xs font-semibold text-slate-500">
                <span>TANGGAL ACARA</span>
                <span class="text-slate-900 font-bold">{{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') }} WIB</span>
            </div>
            <div class="flex justify-between text-xs font-semibold text-slate-500">
                <span>TOTAL PEMBAYARAN</span>
                <span class="text-indigo-600 font-black text-sm">
                    @if($transaction->total_price == 0)
                        Gratis
                    @else
                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                    @endif
                </span>
            </div>
        </div>

        <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-2xl text-indigo-900 text-xs font-medium flex items-center gap-3 text-left">
            <span class="text-lg">📧</span>
            <div>
                E-Ticket ber-QR Code telah dikirimkan ke <strong>{{ $transaction->customer_email }}</strong>. Anda juga dapat langsung mengunduh/mencetak tiket melalui tombol di bawah.
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 pt-2">
            <a href="{{ route('tickets.index', ['order_id' => $transaction->order_id]) }}" class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition">
                🎟️ Lihat & Cetak E-Ticket
            </a>
            <a href="{{ route('home') }}" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</main>
@endsection