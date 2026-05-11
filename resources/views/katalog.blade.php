@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-16">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-800 mb-2">Katalog Event</h1>
            <p class="text-slate-500 font-medium">Temukan berbagai acara menarik di Amikom Yogyakarta.</p>
        </div>
        <div class="flex bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
            <button class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold transition">Semua</button>
            <button class="px-6 py-2.5 hover:bg-slate-50 rounded-xl font-bold text-slate-500 transition">Musik</button>
            <button class="px-6 py-2.5 hover:bg-slate-50 rounded-xl font-bold text-slate-500 transition">Teknologi</button>
            <button class="px-6 py-2.5 hover:bg-slate-50 rounded-xl font-bold text-slate-500 transition">Workshop</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Event Card 1 -->
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="relative overflow-hidden aspect-[16/9]">
                <img src="{{ asset('assets/concert.png') }}" alt="Jazz Night" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">Musik</div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">Jazz Night 2024: A Celebration</h3>
                <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>16 November 2024</span>
                </div>
                <div class="flex justify-between items-center pt-6 border-t border-slate-50">
                    <span class="text-2xl font-black text-indigo-600">Rp 150rb</span>
                    <a href="#" class="px-6 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Daftar</a>
                </div>
            </div>
        </div>

        <!-- Event Card 2 -->
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="relative overflow-hidden aspect-[16/9]">
                <img src="{{ asset('assets/workshop.png') }}" alt="AI Future" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">Teknologi</div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">AI & Future: Unleash The Power</h3>
                <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>26 October 2024</span>
                </div>
                <div class="flex justify-between items-center pt-6 border-t border-slate-50">
                    <span class="text-2xl font-black text-indigo-600">Rp 50rb</span>
                    <a href="#" class="px-6 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Daftar</a>
                </div>
            </div>
        </div>

        <!-- Event Card 3 -->
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="relative overflow-hidden aspect-[16/9]">
                <img src="{{ asset('assets/hackathon.png') }}" alt="Hackathon" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">Coding</div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">Hackathon 2024: Ultimate Marathon</h3>
                <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>18-20 October 2024</span>
                </div>
                <div class="flex justify-between items-center pt-6 border-t border-slate-50">
                    <span class="text-2xl font-black text-indigo-600">Gratis</span>
                    <a href="#" class="px-6 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection