@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Left: Poster & Organizer -->
    <div class="lg:col-span-1">
        <div class="sticky top-32 space-y-6">
            @php
                $defaultImage = 'assets/concert.png';
                $catName = strtolower($event->category->name ?? 'uncategorized');
                if (str_contains($catName, 'it') || str_contains($catName, 'teknologi') || str_contains($catName, 'design')) {
                    $defaultImage = 'assets/hackathon.png';
                } elseif (str_contains($catName, 'seminar') || str_contains($catName, 'workshop')) {
                    $defaultImage = 'assets/workshop.png';
                }
                $organizer = $event->partner ?? \App\Models\Partner::first();
            @endphp

            <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
             ? asset('storage/' . $event->poster_path)
             : 'https://placehold.co/200x600' }}" alt="{{ $event->title }}" class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white object-cover aspect-[3/4]">

            <!-- Card Penyelenggara -->
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <h4 class="font-bold text-slate-900 text-sm tracking-wider uppercase">Penyelenggara Acara</h4>
                @if($organizer)
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-700 font-bold rounded-2xl flex items-center justify-center text-lg shadow-inner flex-shrink-0">
                            @if($organizer->logo_url)
                                <img src="{{ $organizer->logo_url }}" class="w-full h-full object-contain p-1 rounded-2xl">
                            @else
                                {{ strtoupper(substr($organizer->name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-slate-800 truncate">{{ $organizer->name }}</p>
                            <div class="flex items-center gap-1 text-xs text-yellow-500 font-bold">
                                <span>★ {{ $organizer->averageRating() > 0 ? $organizer->averageRating() : '5.0' }}</span>
                                <span class="text-slate-400 font-normal">({{ $organizer->totalReviews() }} Ulasan)</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('partners.show', $organizer->id) }}" class="block text-center w-full py-2.5 bg-slate-100 hover:bg-indigo-50 text-indigo-600 font-bold text-xs rounded-xl transition-colors">
                        Lihat Rekam Jejak Penyelenggara &rarr;
                    </a>
                @else
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            AB
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">ABP Productions</p>
                            <p class="text-xs text-slate-500">Verified Organizer</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right: Details, Ticket & Rating Reviews Section -->
    <div class="lg:col-span-2 space-y-12">
        <div class="space-y-4">
            <div class="flex flex-wrap items-center gap-3">
                <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">{{ $event->category->name }}</span>

                <!-- Rating Badge -->
                <div class="flex items-center gap-1 px-3 py-1 bg-amber-50 border border-amber-200 text-amber-700 rounded-full text-xs font-bold">
                    <span class="text-yellow-400 text-sm">★</span>
                    <span>{{ $event->averageRating() > 0 ? $event->averageRating() : '5.0' }}</span>
                    <span class="text-slate-400">({{ $event->totalReviews() }} testimoni)</span>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>
            <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} WIB</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $event->location }}</span>
                </div>
            </div>
        </div>

        <div class="prose prose-slate max-w-none">
            <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
            <div class="text-lg text-slate-600 leading-relaxed">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>

        @if($event->isCompleted())
        <div class="bg-slate-800 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-slate-100 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <p class="text-slate-300 font-bold uppercase tracking-widest text-sm mb-2">Status Event</p>
                    <h2 class="text-4xl font-black">
                        Event Telah Selesai
                    </h2>
                    <p class="mt-4 text-slate-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Dilaksanakan pada: <span class="font-bold underline">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                    </p>
                </div>
                <div>
                    <a href="#starContainer"
                        class="inline-block px-10 py-5 bg-amber-500 text-white rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                        ★ Beri / Lihat Rating
                    </a>
                </div>
            </div>
            <!-- Decoration -->
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-5 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-slate-600 opacity-10 rounded-full"></div>
        </div>
        @else
        <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                    <h2 class="text-5xl font-black">
                        @if($event->price == 0)
                            Gratis
                        @else
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        @endif
                        <span class="text-lg font-medium text-indigo-200">/ orang</span>
                    </h2>
                    <p class="mt-4 text-indigo-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                    </p>
                </div>
                <div>
                    <a href="{{url('checkout/'.$event->id)}}"
                        class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
            <!-- Decoration -->
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
        </div>
        @endif

        <!-- ======================================================== -->
        <!-- SISTEM ULASAN DAN PENILAIAN BINTANG (RATING & REVIEW)    -->
        <!-- ======================================================== -->
        <div class="space-y-8 pt-6 border-t border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Ulasan & Rating Acara</h3>
                    <p class="text-slate-500 text-sm">Penilaian dan testimoni transparan dari para peserta acara.</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-black text-slate-900 flex items-center gap-1 justify-end">
                        <span class="text-yellow-400">★</span> {{ $event->averageRating() > 0 ? $event->averageRating() : '5.0' }}
                    </div>
                    <span class="text-xs text-slate-400 font-semibold">{{ $event->totalReviews() }} Testimoni</span>
                </div>
            </div>

            <!-- Flash Alert Success / Error -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-semibold text-sm flex items-center gap-3">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl font-semibold text-sm flex items-center gap-3">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            <!-- Form Pemberian Ulasan Pasca-Acara -->
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
                <h4 class="font-bold text-slate-900 text-lg flex items-center gap-2">
                    <span>✍️</span> Berikan Rating & Testimoni Anda
                </h4>

                @if(!$event->isCompleted())
                    <!-- Acara Belum Selesai -->
                    <div class="p-6 bg-amber-500/10 border border-amber-500/20 rounded-2xl text-amber-800 text-sm space-y-2">
                        <div class="flex items-center gap-2 font-bold text-amber-900">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Penilaian & Ulasan Pasca-Acara Terkunci
                        </div>
                        <p class="text-xs text-amber-700">
                            Fitur rating (1-5 bintang) & testimoni akan otomatis terbuka <strong>sehari setelah acara selesai tuntas</strong> (setelah tanggal {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}).
                        </p>
                    </div>
                @elseif(!Auth::check())
                    <!-- Belum Login -->
                    <div class="p-6 bg-indigo-50 border border-indigo-100 rounded-2xl text-indigo-900 text-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <p class="font-bold">Apakah Anda mengikuti acara ini?</p>
                            <p class="text-xs text-indigo-700">Silakan login untuk membagikan ulasan dan penilaian bintang Anda.</p>
                        </div>
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md transition-all whitespace-nowrap">
                            Login untuk Mengulas
                        </a>
                    </div>
                @else
                    <!-- Form Rating Bintang 1-5 Interaktif -->
                    @php
                        $myReview = $event->reviews()->where('user_id', Auth::id())->first();
                    @endphp

                    <form action="{{ route('events.reviews.store', $event->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Pilih Penilaian Bintang (1 - 5)
                            </label>
                            
                            <!-- Star Selection Input -->
                            <div class="flex items-center gap-2 text-3xl cursor-pointer select-none" id="starContainer">
                                @for($star = 1; $star <= 5; $star++)
                                    <span class="star-btn transition-transform hover:scale-125 text-slate-300" data-rating="{{ $star }}">★</span>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', $myReview->rating ?? '') }}" required>
                            <p class="text-xs font-bold text-indigo-600" id="ratingLabel">
                                {{ $myReview ? 'Rating Anda sebelumnya: ' . $myReview->rating . ' Bintang' : 'Klik bintang untuk memilih' }}
                            </p>
                            @error('rating')
                                <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="review" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Ulasan / Testimoni Acara
                            </label>
                            <textarea name="review" id="review" rows="3" required placeholder="Tuliskan pengalaman & kelebihan acara ini..." class="w-full p-4 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all shadow-sm">{{ old('review', $myReview->review ?? '') }}</textarea>
                            @error('review')
                                <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all hover:scale-105">
                            {{ $myReview ? 'Perbarui Testimoni' : 'Kirim Ulasan & Rating' }}
                        </button>
                    </form>
                @endif
            </div>

            <!-- List Feed Ulasan Peserta -->
            <div class="space-y-4">
                <h4 class="font-bold text-slate-900 text-lg">Testimoni Peserta ({{ $event->reviews->count() }})</h4>

                @if($event->reviews->isEmpty())
                    <p class="text-slate-400 text-sm py-4 italic">Belum ada ulasan untuk event ini. Jadilah yang pertama memberikan penilaian!</p>
                @else
                    <div class="space-y-4">
                        @foreach($event->reviews()->with('user')->latest()->get() as $rev)
                            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-indigo-100 text-indigo-700 font-black rounded-full flex items-center justify-center text-xs">
                                            {{ strtoupper(substr($rev->user->name ?? 'User', 0, 2)) }}
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-900 text-sm">{{ $rev->user->name ?? 'Peserta' }}</h5>
                                            <span class="text-[10px] font-semibold text-slate-400">{{ $rev->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="text-yellow-400 text-sm">
                                        @for($s = 1; $s <= 5; $s++)
                                            <span>{{ $s <= $rev->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    "{{ $rev->review }}"
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
            <ul class="space-y-3 text-slate-500">
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tiket dapat discan di pintu masuk (Check-in).
                </li>
                <li class="flex items-start gap-2 text-rose-500">
                    <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tiket yang sudah dibeli tidak dapat direfund.
                </li>
            </ul>
        </div>
    </div>
</main>

<!-- JavaScript Interaktif Bintang Rating 1 - 5 -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#starContainer .star-btn');
    const ratingInput = document.getElementById('ratingInput');
    const ratingLabel = document.getElementById('ratingLabel');

    const labels = {
        1: '1 Bintang - Sangat Kecewa 😞',
        2: '2 Bintang - Kurang Memuaskan 🙁',
        3: '3 Bintang - Cukup Baik 😐',
        4: '4 Bintang - Sangat Bagus! 😊',
        5: '5 Bintang - Luar Biasa Sempurna! ⭐⭐⭐⭐⭐'
    };

    function updateStars(rating) {
        stars.forEach(star => {
            const r = parseInt(star.getAttribute('data-rating'));
            if (r <= rating) {
                star.classList.remove('text-slate-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-slate-300');
            }
        });
        if (labels[rating]) {
            ratingLabel.textContent = labels[rating];
        }
    }

    if (ratingInput && ratingInput.value) {
        updateStars(parseInt(ratingInput.value));
    }

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            ratingInput.value = rating;
            updateStars(rating);
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            updateStars(rating);
        });
    });

    const starContainer = document.getElementById('starContainer');
    if (starContainer) {
        starContainer.addEventListener('mouseleave', function() {
            const currentVal = parseInt(ratingInput.value) || 0;
            updateStars(currentVal);
            if (!currentVal) {
                ratingLabel.textContent = 'Klik bintang untuk memilih';
            }
        });
    }
});
</script>
@endsection