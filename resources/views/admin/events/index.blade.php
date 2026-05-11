@extends('layouts.admin')

@section('title', 'Manajemen Event')
@section('page_title', 'Kelola Event Acara')
@section('page_subtitle', 'Pantau dan kelola semua event yang terdaftar di platform.')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b flex justify-between items-center bg-white sticky top-0 z-10">
        <div>
            <h3 class="font-black text-xl">Daftar Event</h3>
            <p class="text-slate-500 text-sm font-medium">Total {{ $events->total() }} event terdaftar</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition flex items-center gap-2 shadow-lg shadow-indigo-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Event
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Kategori</th>
                    <th class="px-8 py-4">Waktu & Lokasi</th>
                    <th class="px-8 py-4">Harga & Stok</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t border-slate-50">
                @forelse($events as $event)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 border">
                                @if($event->poster_path)
                                                                        <img src="{{ str_starts_with($event->poster_path, 'assets/') ? asset($event->poster_path) : Storage::url($event->poster_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition">{{ $event->title }}</p>
                                <p class="text-xs text-slate-400 font-medium">ID: #{{ str_pad($event->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-bold text-[10px] uppercase tracking-wider">
                            {{ $event->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                        <p class="text-xs text-slate-400 font-medium">{{ $event->location }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-400 font-medium">Stok: {{ $event->stock }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-20">
                        <div class="max-w-xs mx-auto">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <p class="text-slate-500 font-bold">Belum ada event</p>
                            <p class="text-slate-400 text-sm mb-6">Mulai tambahkan event pertama Anda sekarang.</p>
                            <a href="{{ route('admin.events.create') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Tambah Event</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($events->hasPages())
    <div class="p-8 border-t bg-slate-50">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection