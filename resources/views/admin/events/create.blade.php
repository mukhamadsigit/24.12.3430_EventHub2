@extends('layouts.admin')

@section('title', 'Tambah Event')
@section('page_title', 'Tambah Event Baru')
@section('page_subtitle', 'Silakan isi formulir di bawah untuk menambahkan event baru.')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 font-bold text-slate-700">Judul Event</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('title') border-rose-500 @enderror" placeholder="Contoh: Jazz Night 2024" required>
                    @error('title')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-bold text-slate-700">Kategori Event</label>
                    <select name="category_id" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('category_id') border-rose-500 @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-bold text-slate-700">Lokasi / Gedung</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('location') border-rose-500 @enderror" placeholder="Contoh: Cinema Amikom" required>
                    @error('location')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block mb-2 font-bold text-slate-700">Poster Event</label>
                    <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-indigo-500 transition cursor-pointer relative group">
                        <input type="file" name="poster" class="absolute inset-0 opacity-0 cursor-pointer">
                        <div class="space-y-2">
                            <svg class="w-10 h-10 text-slate-400 mx-auto group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-sm text-slate-500">Klik atau seret file poster ke sini</p>
                            <p class="text-xs text-slate-400">PNG, JPG (Max. 2MB)</p>
                        </div>
                    </div>
                    @error('poster')
                        <p class="text-rose-500 text-xs mt-1 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 font-bold text-slate-700">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('price') border-rose-500 @enderror" placeholder="0" required>
                        @error('price')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-2 font-bold text-slate-700">Stok Tiket</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('stock') border-rose-500 @enderror" placeholder="100" required>
                        @error('stock')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-2 font-bold text-slate-700">Tanggal & Waktu</label>
                    <input type="datetime-local" name="date" value="{{ old('date') }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('date') border-rose-500 @enderror" required>
                    @error('date')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-8">
            <label class="block mb-2 font-bold text-slate-700">Deskripsi Event</label>
            <textarea name="description" class="w-full border border-slate-200 p-4 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('description') border-rose-500 @enderror" rows="5" placeholder="Jelaskan detail event di sini..." required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4 border-t pt-8">
            <a href="{{ route('admin.events.index') }}" class="px-8 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Simpan Event</button>
        </div>
    </form>
</div>
@endsection