@extends('layouts.admin')

@section('title', 'Edit Event')
@section('page_title', 'Edit Data Event')
@section('page_subtitle', 'Sesuaikan detail event Anda di bawah ini.')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 font-bold text-slate-700">Judul Event</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('title') border-rose-500 @enderror" required>
                    @error('title')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-bold text-slate-700">Kategori Event</label>
                    <select name="category_id" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('category_id') border-rose-500 @enderror" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-bold text-slate-700">Lokasi / Gedung</label>
                    <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('location') border-rose-500 @enderror" required>
                    @error('location')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-6">
                <div class="mb-6">
                    <label class="block mb-2 font-medium text-gray-700">Poster Event (Opsional)</label>
                    @if($event->poster_path)
                        <div class="mb-3">
                            <img src="{{ Storage::url($event->poster_path) }}" class="w-20 h-20 object-cover rounded-xl border">
                        </div>
                    @endif
                    <input type="file" name="poster" accept="image/*" class="w-full border border-gray-300 p-2.5 rounded">
                    @error('poster')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 font-bold text-slate-700">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', $event->price) }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('price') border-rose-500 @enderror" required>
                        @error('price')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-2 font-bold text-slate-700">Stok Tiket</label>
                        <input type="number" name="stock" value="{{ old('stock', $event->stock) }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('stock') border-rose-500 @enderror" required>
                        @error('stock')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-2 font-bold text-slate-700">Tanggal & Waktu</label>
                    <input type="datetime-local" name="date" value="{{ old('date', date('Y-m-d\TH:i', strtotime($event->date))) }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('date') border-rose-500 @enderror" required>
                    @error('date')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-8">
            <label class="block mb-2 font-bold text-slate-700">Deskripsi Event</label>
            <textarea name="description" class="w-full border border-slate-200 p-4 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('description') border-rose-500 @enderror" rows="5" required>{{ old('description', $event->description) }}</textarea>
            @error('description')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4 border-t pt-8">
            <a href="{{ route('admin.events.index') }}" class="px-8 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Update Event</button>
        </div>
    </form>
</div>
@endsection