@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-16">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-800 mb-2">Katalog Event</h1>
            <p class="text-slate-500 font-medium">Temukan berbagai acara menarik di Amikom Yogyakarta.</p>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-4 items-center w-full md:w-auto">
            <!-- Search Form -->
            <form action="{{ route('katalog') }}" method="GET" class="relative w-full md:w-64">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event..." 
                       class="w-full border border-slate-200 pl-10 pr-4 py-2.5 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition text-sm">
                <div class="absolute left-3.5 top-3 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>

            <!-- Categories -->
            <div class="flex bg-white p-1 rounded-xl border border-slate-100 shadow-sm flex-wrap gap-1 w-full lg:w-auto justify-center">
                <a href="{{ route('katalog', ['search' => request('search')]) }}" class="px-4 py-2 {{ !request('category') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-50 text-slate-500' }} rounded-lg font-bold text-xs transition whitespace-nowrap">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('katalog', ['category' => $cat->slug, 'search' => request('search')]) }}" class="px-4 py-2 {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white' : 'hover:bg-slate-50 text-slate-500' }} rounded-lg font-bold text-xs transition whitespace-nowrap">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden aspect-[16/9]">
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
                     : 'https://placehold.co/200x600' }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">{{ $event->category->name ?? 'Uncategorized' }}</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-6 border-t border-slate-50">
                        <span class="text-2xl font-black text-indigo-600">
                            @if($event->price == 0)
                                Gratis
                            @else
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            @endif
                        </span>
                        <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition text-xs shadow-md shadow-indigo-100">
                            Pesan Tiket &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="bg-slate-50 rounded-3xl p-12 border-2 border-dashed border-slate-200">
                    <p class="text-slate-500 text-lg font-medium">Belum ada event tersedia.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($events->hasPages())
        <div class="mt-12">
            {{ $events->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection