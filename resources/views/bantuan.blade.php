@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-slate-800 mb-4">Pusat Bantuan</h1>
        <p class="text-lg text-slate-500">Temukan jawaban untuk pertanyaan Anda seputar layanan kami.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Cara Mendaftar Event</h3>
            <p class="text-slate-500 leading-relaxed">Cari event yang Anda inginkan di halaman Katalog, klik tombol 'Lihat Detail', lalu ikuti petunjuk pendaftaran yang tersedia.</p>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Masalah Pembayaran?</h3>
            <p class="text-slate-500 leading-relaxed">Pastikan saldo Anda cukup dan koneksi internet stabil. Jika transaksi gagal namun saldo terpotong, segera hubungi admin kami.</p>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Lokasi Event</h3>
            <p class="text-slate-500 leading-relaxed">Detail lokasi lengkap beserta Google Maps dapat Anda temukan di halaman detail setiap event yang terdaftar.</p>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Lupa Password?</h3>
            <p class="text-slate-500 leading-relaxed">Gunakan fitur 'Lupa Password' pada halaman login untuk mengatur ulang kata sandi melalui email Anda yang terdaftar.</p>
        </div>
    </div>

    <div class="mt-20 p-12 bg-indigo-600 rounded-[2rem] text-center text-white shadow-xl shadow-indigo-200">
        <h2 class="text-3xl font-bold mb-4">Masih butuh bantuan?</h2>
        <p class="text-indigo-100 mb-8 max-w-lg mx-auto">Tim support kami tersedia melalui WhatsApp untuk membantu menyelesaikan kendala Anda secara langsung.</p>
        <a href="https://wa.me/6281234567890" class="inline-block bg-white text-indigo-600 font-bold py-4 px-10 rounded-2xl hover:bg-indigo-50 transition duration-300">
            Hubungi via WhatsApp
        </a>
    </div>
</div>
@endsection