@extends('layouts.app')
@section('title', 'Pemesanan Tiket - ' . $event->title)

@section('content')
<main class="max-w-5xl mx-auto px-6 py-12 space-y-8">
    <!-- Breadcrumb & Nav Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('events.show', $event->id) }}"
            class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-800 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Detail Event
        </a>
        
        <!-- Progress Steps -->
        <div class="hidden sm:flex items-center gap-3 text-xs font-bold text-slate-400">
            <span class="text-indigo-600 flex items-center gap-1">
                <span class="w-5 h-5 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px]">1</span>
                Data Pemesan
            </span>
            <span>&rarr;</span>
            <span class="flex items-center gap-1">
                <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px]">2</span>
                Pembayaran
            </span>
            <span>&rarr;</span>
            <span class="flex items-center gap-1">
                <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px]">3</span>
                E-Ticket
            </span>
        </div>
    </div>

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl font-bold text-sm flex items-center gap-3">
            <span>⚠️</span> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Left: Summary Card (1 Column) -->
        <div class="lg:col-span-1 space-y-6 sticky top-28">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-6">
                <h3 class="font-black text-slate-900 text-lg border-b border-slate-100 pb-4">Ringkasan Pemesanan</h3>
                
                <div class="flex gap-4 items-start">
                    <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                        ? asset('storage/' . $event->poster_path)
                        : 'https://placehold.co/200x200' }}"
                        alt="{{ $event->title }}" class="w-20 h-24 rounded-2xl object-cover border border-slate-100 flex-shrink-0 shadow-sm">
                    <div class="space-y-1 min-w-0">
                        <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 rounded-full text-[10px] font-bold uppercase tracking-wider">
                            {{ $event->category->name ?? 'Event' }}
                        </span>
                        <h4 class="font-bold text-slate-900 text-sm line-clamp-2">{{ $event->title }}</h4>
                        <p class="text-xs text-slate-500 flex items-center gap-1">
                            <span>📅</span> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <!-- Price Breakdown -->
                <div class="pt-4 border-t border-slate-100 space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Harga Tiket (1x)</span>
                        <span class="font-bold">
                            @if($event->price == 0)
                                Gratis
                            @else
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between text-slate-600">
                        <span>Biaya Layanan & Admin</span>
                        <span class="font-bold">
                            @if($event->price == 0)
                                Rp 0
                            @else
                                Rp 5.000
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-lg font-black pt-4 border-t border-slate-200">
                        <span>Total Bayar</span>
                        <span class="text-indigo-600 text-xl">
                            @if($event->price == 0)
                                Gratis
                            @else
                                Rp {{ number_format($event->price + 5000, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Trust Guarantee Card -->
            <div class="p-5 bg-indigo-50/70 border border-indigo-100 rounded-2xl text-indigo-950 text-xs space-y-2">
                <div class="flex items-center gap-2 font-bold text-indigo-900">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Jaminan Tiket Resmi & Aman
                </div>
                <p class="text-slate-600 leading-relaxed">
                    E-Ticket resmi ber-QR Code akan dikirim otomatis ke alamat email yang Anda masukkan.
                </p>
            </div>
        </div>

        <!-- Right: Form Card (2 Columns) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-2xl font-black text-slate-900">Data Pemesan Tiket</h2>
                <p class="text-slate-500 text-sm mt-1">Pastikan data yang diisi sesuai dengan identitas asli Anda.</p>
            </div>

            <form action="{{ route('checkout.store', $event->id) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Nama Lengkap Sesuai KTP / Identitas
                    </label>
                    <input type="text" name="customer_name"
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition font-medium text-slate-900 text-sm"
                        required value="{{ old('customer_name', Auth::check() ? Auth::user()->name : '') }}">
                    @error('customer_name')
                        <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Grid Email & Telepon -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Email Aktif
                        </label>
                        <input type="email" name="customer_email"
                            placeholder="budi@gmail.com"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition font-medium text-slate-900 text-sm"
                            required value="{{ old('customer_email', Auth::check() ? Auth::user()->email : '') }}">
                        <p class="text-[11px] text-slate-400 font-medium">E-Ticket PDF akan dikirimkan ke email ini.</p>
                        @error('customer_email')
                            <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Nomor WhatsApp / HP
                        </label>
                        <input type="tel" name="customer_phone"
                            placeholder="081234567890"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition font-medium text-slate-900 text-sm"
                            required value="{{ old('customer_phone') }}">
                        <p class="text-[11px] text-slate-400 font-medium">Untuk konfirmasi & bantuan tiket.</p>
                        @error('customer_phone')
                            <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 space-y-3">
                    <button type="submit"
                        class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all flex items-center justify-center gap-2">
                        <span>
                            @if($event->price == 0)
                                Dapatkan Tiket Gratis Sekarang
                            @else
                                Lanjut Pembayaran (Rp {{ number_format($event->price + 5000, 0, ',', '.') }})
                            @endif
                        </span>
                        <span>&rarr;</span>
                    </button>

                    <p class="text-center text-xs text-slate-400">
                        Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan layanan AmikomEventHub.
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection