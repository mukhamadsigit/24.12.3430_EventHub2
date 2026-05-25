@extends('layouts.admin')

@section('title', 'Tambah Partner')
@section('page_title', 'Tambah Partner Baru')
@section('page_subtitle', 'Masukkan informasi partner yang akan bekerja sama.')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <form action="{{ route('admin.partners.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label for="name" class="text-sm font-bold text-slate-700 ml-1">Nama Partner</label>
                <input type="text" name="name" id="name" required placeholder="Contoh: Amikom University"
                       class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all font-medium">
            </div>

            <div class="space-y-2">
                <label for="logo_url" class="text-sm font-bold text-slate-700 ml-1">URL Logo Partner</label>
                <input type="url" name="logo_url" id="logo_url" required placeholder="https://example.com/logo.png"
                       class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all font-medium">
                <p class="text-[10px] text-slate-400 ml-1">Gunakan link gambar langsung dari internet.</p>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Simpan Partner
                </button>
                <a href="{{ route('admin.partners.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">
                    Batal
                </a >
            </div>
        </form>
    </div>
</div>
@endsection
