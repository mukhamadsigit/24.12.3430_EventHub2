@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 space-y-12">
    <!-- Header Profil Penyelenggara -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="w-32 h-32 rounded-3xl bg-white/10 backdrop-blur-md p-3 border border-white/20 shadow-2xl flex-shrink-0 flex items-center justify-center">
                @if($partner->logo_url)
                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="w-full h-full object-contain rounded-2xl">
                @else
                    <div class="w-full h-full bg-indigo-600 rounded-2xl flex items-center justify-center text-3xl font-black text-white">
                        {{ strtoupper(substr($partner->name, 0, 2)) }}
                    </div>
                @endif
            </div>

            <div class="flex-1 text-center md:text-left space-y-4">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                    <h1 class="text-3xl md:text-5xl font-black tracking-tight">{{ $partner->name }}</h1>
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Penyelenggara Terverifikasi
                    </span>
                </div>
                <p class="text-slate-300 text-lg max-w-2xl">
                    Rekam jejak penilaian & testimoni kepercayaan publik dari acara-acara yang diselenggarakan oleh {{ $partner->name }}.
                </p>

                <!-- Stat Summary Badges -->
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 pt-2">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/10">
                        <div class="text-yellow-400 flex items-center gap-1 text-2xl font-black">
                            ★ <span>{{ $averageRating > 0 ? $averageRating : '5.0' }}</span>
                        </div>
                        <div class="text-xs text-slate-300 font-medium">
                            <div>Rata-rata Rating</div>
                            <div class="font-bold text-white">({{ $totalReviews }} Ulasan)</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/10">
                        <div class="text-indigo-400 font-black text-2xl">
                            {{ $events->count() }}
                        </div>
                        <div class="text-xs text-slate-300 font-medium">
                            <div>Total Acara</div>
                            <div class="font-bold text-white">Diselenggarakan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative Glow -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-indigo-500/20 blur-3xl rounded-full"></div>
    </div>

    <!-- Layout Grid: Left Statistics & Reviews, Right Events -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main: Review Feed & Breakdown (2 Columns) -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Card Rekam Jejak Rating & Distribusi Bintang -->
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                <h3 class="text-2xl font-black text-slate-900 flex items-center gap-3">
                    <svg class="w-7 h-7 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    Rekam Jejak Penilaian Penyelenggara
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 items-center bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <div class="text-center sm:border-r border-slate-200 pr-4">
                        <div class="text-5xl font-black text-slate-900">
                            {{ $averageRating > 0 ? $averageRating : '5.0' }}
                        </div>
                        <div class="flex justify-center text-yellow-400 text-xl my-2">
                            @for($i = 1; $i <= 5; $i++)
                                <span>{{ $i <= round($averageRating) ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <p class="text-sm font-semibold text-slate-500">Dari {{ $totalReviews }} testimoni peserta</p>
                    </div>

                    <!-- Breakdown Bintang 1 - 5 -->
                    <div class="sm:col-span-2 space-y-2">
                        @foreach([5, 4, 3, 2, 1] as $star)
                            @php
                                $count = $ratingBreakdown[$star] ?? 0;
                                $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-600">
                                <span class="w-12 flex items-center gap-1">
                                    {{ $star }} <span class="text-yellow-400">★</span>
                                </span>
                                <div class="flex-1 h-3 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="w-10 text-right text-slate-400 font-semibold">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Daftar Ulasan & Testimoni -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-slate-900">Testimoni & Ulasan Peserta ({{ $totalReviews }})</h3>

                @if($reviews->isEmpty())
                    <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm space-y-4">
                        <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto text-3xl">
                            💬
                        </div>
                        <h4 class="text-lg font-bold text-slate-800">Belum Ada Testimoni Pasca-Acara</h4>
                        <p class="text-slate-500 max-w-md mx-auto text-sm">
                            Testimoni akan otomatis bermunculan dari peserta sehari setelah acara yang diadakan oleh penyelenggara ini tuntas dilaksanakan.
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($reviews as $rev)
                            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-indigo-100 text-indigo-700 font-black rounded-full flex items-center justify-center text-sm">
                                            {{ strtoupper(substr($rev->user->name ?? 'User', 0, 2)) }}
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-900 text-sm">{{ $rev->user->name ?? 'Peserta' }}</h5>
                                            <p class="text-xs text-slate-400">
                                                Acara: <span class="font-semibold text-slate-600">{{ $rev->event->title ?? 'Event' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-yellow-400 text-sm">
                                            @for($s = 1; $s <= 5; $s++)
                                                <span>{{ $s <= $rev->rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                        <span class="text-[10px] font-semibold text-slate-400">{{ $rev->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <p class="text-slate-700 text-sm leading-relaxed bg-slate-50/70 p-4 rounded-2xl border border-slate-100">
                                    "{{ $rev->review }}"
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar: Event yang Diselenggarakan -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-6 sticky top-28">
                <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Acara Diselenggarakan
                </h3>

                @if($events->isEmpty())
                    <p class="text-slate-400 text-sm text-center py-6">Belum ada acara yang terhubung.</p>
                @else
                    <div class="space-y-4">
                        @foreach($events as $ev)
                            <a href="{{ route('events.show', $ev->id) }}" class="block group bg-slate-50 hover:bg-indigo-50/50 p-4 rounded-2xl border border-slate-100 transition-all">
                                <div class="flex gap-4 items-center">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-slate-200">
                                        <img src="{{ ($ev->poster_path && Storage::disk('public')->exists($ev->poster_path)) ? asset('storage/' . $ev->poster_path) : 'https://placehold.co/100' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    </div>
                                    <div class="space-y-1 min-w-0">
                                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-100/70 px-2 py-0.5 rounded-full uppercase">{{ $ev->category->name ?? 'Event' }}</span>
                                        <h4 class="font-bold text-slate-900 text-sm truncate group-hover:text-indigo-600 transition-colors">{{ $ev->title }}</h4>
                                        <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($ev->date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
