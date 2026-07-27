@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
            #1 Event Platform
        </span>
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
        </h1>
        <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
        </p>
        <div class="flex gap-4">
            <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                Mulai Jelajah
            </a>
            <a href="#completed-reviews" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition flex items-center gap-2">
                <span class="text-yellow-500">★</span> Rating Pasca-Acara
            </a>
        </div>
    </div>
    <div class="flex-1 relative">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <img src="{{ asset('assets/concert.png') }}" alt="Concert" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="font-bold">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section id="events" class="max-w-7xl mx-auto px-6 py-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
        <div>
            <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
            <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
        </div>
        
        <!-- Filter Kategori Dinamis -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('home') }}" 
               class="px-5 py-2.5 rounded-xl border {{ !request('category') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 hover:border-indigo-600' }} transition-all font-semibold text-sm">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->slug]) }}" 
                   class="px-5 py-2.5 rounded-xl border {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 hover:border-indigo-600' }} transition-all font-semibold text-sm">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Zona Menampilkan Grid List Event -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col justify-between">
                
                <div>
                    <!-- Bagian Gambar & Label Kategori -->
                    <div class="relative overflow-hidden aspect-[3/4]">
                        @php
                            $defaultImage = 'assets/concert.png';
                            $catName = strtolower($event->category->name ?? 'uncategorized');
                            if (str_contains($catName, 'it') || str_contains($catName, 'teknologi') || str_contains($catName, 'design')) {
                                $defaultImage = 'assets/hackathon.png';
                            } elseif (str_contains($catName, 'seminar') || str_contains($catName, 'workshop')) {
                                $defaultImage = 'assets/workshop.png';
                            }
                        @endphp
                        <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                         ? asset('storage/' . $event->poster_path)
                         : 'https://placehold.co/200x600' }}" alt="{{ $event->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        
                        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600 shadow">
                            {{ $event->category->name ?? 'Uncategorized' }}
                        </div>

                        @if($event->isCompleted())
                            <div class="absolute top-4 right-4 px-3 py-1 bg-amber-500 text-white backdrop-blur rounded-lg text-xs font-black uppercase shadow flex items-center gap-1">
                                <span>★</span> {{ $event->averageRating() > 0 ? $event->averageRating() : '5.0' }}
                            </div>
                        @endif
                    </div>

                    <!-- Bagian Konten/Teks -->
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold group-hover:text-indigo-600 transition line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        
                        <div class="flex items-center gap-2 text-slate-500 text-sm">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</span>
                        </div>

                        <!-- Status Pasca-Acara vs Mendatang -->
                        @if($event->isCompleted())
                            <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-center justify-between text-xs text-amber-900 font-bold">
                                <span class="flex items-center gap-1">
                                    <span class="text-yellow-500 text-sm">★</span>
                                    <span>Penilaian Pasca-Acara Terbuka</span>
                                </span>
                                <span class="text-slate-500 font-normal">({{ $event->totalReviews() }} ulasan)</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Bagian Harga & Tombol Aksi -->
                <div class="p-6 pt-0">
                    <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                        <span class="text-2xl font-black text-indigo-600">
                            @if($event->price == 0)
                                Gratis
                            @else
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            @endif
                        </span>
                        
                        @if($event->isCompleted())
                            <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition flex items-center gap-1 shadow-md text-xs">
                                <span>★</span> Beri / Lihat Rating
                            </a>
                        @else
                            <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition text-xs shadow-md shadow-indigo-100">
                                Pesan Tiket &rarr;
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="bg-slate-50 rounded-3xl p-12 border-2 border-dashed border-slate-200">
                    <p class="text-slate-500 text-lg font-medium">Belum ada event tersedia untuk kategori ini.</p>
                </div>
            </div>
        @endforelse
    </div>
</section>

<!-- ======================================================== -->
<!-- SEKSI PENILAIAN BINTANG PASCA-ACARA DI HALAMAN UTAMA     -->
<!-- ======================================================== -->
<section id="completed-reviews" class="bg-slate-900 text-white py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 space-y-12 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-slate-800 pb-8">
            <div class="space-y-3">
                <span class="px-4 py-1.5 bg-amber-500/20 text-amber-400 border border-amber-500/30 rounded-full text-xs font-bold uppercase tracking-widest inline-flex items-center gap-1.5">
                    <span>★</span> Rating & Testimoni Pasca-Acara
                </span>
                <h2 class="text-3xl md:text-5xl font-black tracking-tight">
                    Penilaian Bintang Event yang Telah Selesai
                </h2>
                <p class="text-slate-400 text-base max-w-2xl">
                    Sistem ulasan interaktif yang terbuka secara otomatis bagi peserta <strong>setelah 1 hari event dilaksanakan</strong> untuk memberikan transparansi dan nilai bintang (1-5 bintang).
                </p>
            </div>
        </div>

        @if($completedEvents->isEmpty())
            <div class="bg-slate-800/60 rounded-3xl p-12 text-center border border-slate-700 space-y-3">
                <div class="text-4xl">🌟</div>
                <h3 class="text-xl font-bold text-slate-200">Belum Ada Event Pasca-Acara</h3>
                <p class="text-slate-400 text-sm">Penilaian bintang akan otomatis tampil di halaman utama setelah event tuntas dilaksanakan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($completedEvents as $compEv)
                    <div class="bg-slate-800/90 rounded-3xl p-6 border border-slate-700/80 shadow-xl flex flex-col justify-between space-y-6 hover:border-amber-500/50 transition-all duration-300">
                        <div class="space-y-4">
                            <!-- Category & Star Badge -->
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-lg text-xs font-bold uppercase">
                                    {{ $compEv->category->name ?? 'Event' }}
                                </span>
                                <div class="flex items-center gap-1 px-3 py-1 bg-amber-500/20 text-amber-400 border border-amber-500/30 rounded-full text-xs font-black">
                                    <span>★</span>
                                    <span>{{ $compEv->averageRating() > 0 ? $compEv->averageRating() : '5.0' }}</span>
                                    <span class="text-slate-400 font-normal">({{ $compEv->totalReviews() }})</span>
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-white line-clamp-2">
                                {{ $compEv->title }}
                            </h3>

                            <p class="text-xs text-slate-400 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal Pelaksanaan: {{ \Carbon\Carbon::parse($compEv->date)->format('d M Y') }}
                            </p>

                            <!-- Latest Review snippet -->
                            @php
                                $latestRev = $compEv->reviews->last();
                            @endphp
                            @if($latestRev)
                                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-700/60 space-y-2">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="font-bold text-slate-300">{{ $latestRev->user->name ?? 'Peserta' }}</span>
                                        <span class="text-yellow-400">
                                            @for($i=1;$i<=5;$i++)
                                                {{ $i <= $latestRev->rating ? '★' : '☆' }}
                                            @endfor
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 italic line-clamp-2">"{{ $latestRev->review }}"</p>
                                </div>
                            @else
                                <div class="bg-slate-900/40 p-4 rounded-2xl border border-slate-800 text-xs text-slate-400 italic">
                                    Belum ada testimoni tersimpan. Jadilah peserta pertama yang memberikan rating 1-5 bintang!
                                </div>
                            @endif
                        </div>

                        <!-- Action Button to Submit/View Rating -->
                        <div class="pt-4 border-t border-slate-700/60 flex items-center justify-between gap-4">
                            <div class="text-xs text-slate-400 font-medium">
                                {{ $compEv->totalReviews() }} Ulasan Peserta
                            </div>
                            <a href="{{ route('events.show', $compEv->id) }}" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-amber-500/20 transition-all flex items-center gap-1.5">
                                <span>★</span> Beri / Lihat Rating
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Glowing backdrop effect -->
    <div class="absolute -right-32 -top-32 w-96 h-96 bg-amber-500/10 blur-3xl rounded-full"></div>
    <div class="absolute -left-32 -bottom-32 w-96 h-96 bg-indigo-500/10 blur-3xl rounded-full"></div>
</section>

<!-- Partners & Platform Categorization Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t border-slate-100">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center">
        <div class="lg:col-span-1">
            <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full font-bold text-xs uppercase tracking-widest">
                Platform Categorization
            </span>
            <h2 class="text-3xl font-black text-slate-800 mt-4 tracking-tight leading-tight">
                Di Bagian Manakah Platform <span class="text-indigo-600">AmikomEventHub</span>?
            </h2>
            <p class="mt-4 text-slate-500 font-medium leading-relaxed">
                AmikomEventHub dikategorikan sebagai platform **Manajemen Event & Ticketing Digital Utama**. Kami menghubungkan komunitas kampus dengan ekosistem event yang luas, didukung oleh partner strategis terpercaya untuk menjamin kelancaran setiap acara.
            </p>
        </div>
        
        <div class="lg:col-span-2 bg-slate-50/50 rounded-3xl p-8 border border-slate-100/80">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-6">Partner Pendukung Kami</h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                @forelse($partners as $partner)
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 flex flex-col items-center justify-center gap-3 group">
                        <div class="h-12 flex items-center justify-center">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain grayscale group-hover:grayscale-0 transition duration-300">
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-indigo-600 transition text-center">{{ $partner->name }}</span>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-slate-400 italic text-sm">
                        Belum ada partner yang terdaftar.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection