@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20 text-center">
    <div class="bg-white p-12 rounded-[2rem] shadow-xl border border-slate-100 relative overflow-hidden">
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-500 rounded-full opacity-10 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-500 rounded-full opacity-10 animate-blob animation-delay-2000"></div>

        <div class="relative z-10">
            <div class="w-32 h-32 bg-indigo-100 rounded-3xl mx-auto mb-8 flex items-center justify-center text-indigo-600">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Amikom Event Hub</h1>
            <p class="text-indigo-600 font-bold uppercase tracking-widest text-sm mb-6">Verified Organization</p>
            
            <div class="max-w-md mx-auto text-slate-500 leading-relaxed mb-10">
                Penyelenggara event resmi Universitas Amikom Yogyakarta. Kami menghadirkan berbagai acara menarik mulai dari seminar, workshop, hingga konser musik.
            </div>

            <div class="flex justify-center gap-4 mb-12">
                <div class="px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                    <p class="text-2xl font-black text-indigo-600">48</p>
                    <p class="text-xs font-bold text-slate-400 uppercase">Events</p>
                </div>
                <div class="px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                    <p class="text-2xl font-black text-indigo-600">2.5k</p>
                    <p class="text-xs font-bold text-slate-400 uppercase">Attendees</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:scale-105 transition">
                    Jelajahi Event
                </a>
                <a href="{{ route('kontak') }}" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold hover:border-indigo-600 hover:text-indigo-600 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection