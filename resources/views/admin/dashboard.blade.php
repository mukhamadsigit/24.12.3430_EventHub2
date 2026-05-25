@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Overview')
@section('page_subtitle', 'Ringkasan data platform Anda hari ini.')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <!-- Stat Card: Events -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 font-medium text-sm">Total Events</p>
                <h3 class="text-2xl font-bold">{{ $eventCount }}</h3>
            </div>
        </div>
        <a href="{{ route('admin.events.index') }}" class="text-indigo-600 font-bold text-xs hover:underline flex items-center gap-1">
            Lihat Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <!-- Stat Card: Categories -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 font-medium text-sm">Total Kategori</p>
                <h3 class="text-2xl font-bold">{{ $categoryCount }}</h3>
            </div>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-purple-600 font-bold text-xs hover:underline flex items-center gap-1">
            Kelola Kategori <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <!-- Stat Card: Partners -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 font-medium text-sm">Total Partners</p>
                <h3 class="text-2xl font-bold">{{ $partnerCount }}</h3>
            </div>
        </div>
        <a href="{{ route('admin.partners.index') }}" class="text-green-600 font-bold text-xs hover:underline flex items-center gap-1">
            Lihat Partner <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
    <!-- Recent Partners -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-lg font-bold">Partner Terbaru</h3>
            <a href="{{ route('admin.partners.create') }}" class="text-indigo-600 text-sm font-bold">+ Tambah</a>
        </div>
        <div class="p-6">
            @forelse($recentPartners as $partner)
                <div class="flex items-center gap-4 mb-4 last:mb-0">
                    <img src="{{ $partner->logo_url }}" class="w-12 h-12 rounded-xl object-contain border p-1" alt="{{ $partner->name }}">
                    <div>
                        <p class="font-bold">{{ $partner->name }}</p>
                        <p class="text-xs text-slate-400">Bergabung {{ $partner->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm italic py-4">Belum ada partner yang ditambahkan.</p>
            @endforelse
        </div>
    </div>

    <!-- Quick Action -->
    <div class="bg-indigo-900 rounded-3xl p-8 text-white relative overflow-hidden flex flex-col justify-between">
        <div class="relative z-10">
            <h3 class="text-2xl font-bold mb-4">Butuh Bantuan?</h3>
            <p class="text-indigo-200 mb-6">Jika Anda mengalami kesulitan dalam mengelola event atau partner, silakan hubungi tim IT Support.</p>
        </div>
        <div class="flex gap-4 relative z-10">
            <a href="#" class="px-6 py-3 bg-white text-indigo-900 rounded-xl font-bold hover:bg-indigo-50 transition">Buka Dokumentasi</a>
        </div>
        
        <!-- Decoration -->
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-800 rounded-full opacity-50"></div>
        <div class="absolute right-10 top-10 w-20 h-20 bg-indigo-700 rounded-full opacity-30"></div>
    </div>
</div>
@endsection