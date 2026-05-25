@extends('layouts.admin')

@section('title', 'Daftar Partner')
@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Daftar semua partner yang bekerja sama dengan platform.')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="text-xl font-bold">Semua Partner</h3>
        </div>
        <div class="flex items-center gap-4 w-full md:w-auto">
            <form action="{{ route('admin.partners.index') }}" method="GET" class="relative flex-1 md:flex-none">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari partner..." 
                       class="w-full md:w-64 border border-slate-200 pl-10 pr-4 py-2.5 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition text-sm">
                <div class="absolute left-3.5 top-3 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>
            <a href="{{ route('admin.partners.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 whitespace-nowrap text-sm">
                + Tambah Partner
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Logo</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Nama Partner</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Logo URL</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6 border-b">
                            <div class="w-16 h-16 bg-white rounded-2xl border p-2 flex items-center justify-center">
                                <img src="{{ $partner->logo_url }}" class="max-w-full max-h-full object-contain" alt="{{ $partner->name }}">
                            </div>
                        </td>
                        <td class="px-8 py-6 border-b font-bold text-slate-700">{{ $partner->name }}</td>
                        <td class="px-8 py-6 border-b text-sm text-slate-400 font-mono">
                            <span class="truncate max-w-xs block" title="{{ $partner->logo_url }}">{{ $partner->logo_url }}</span>
                        </td>
                        <td class="px-8 py-6 border-b">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.partners.edit', $partner->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-slate-400 italic">
                            Belum ada partner yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
