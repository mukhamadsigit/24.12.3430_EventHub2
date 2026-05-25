@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Tambah Partner Baru</h2>
    </div>

    <form action="{{ route('admin.partners.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="name">Nama Partner</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-indigo-500" required placeholder="Contoh: PT Teknologi Nusantara">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2" for="logo_url">URL Logo</label>
            <input type="url" name="logo_url" id="logo_url" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-indigo-500" required placeholder="https://placehold.co/200x200">
            <p class="text-sm text-gray-500 mt-1">Masukkan link URL valid untuk gambar logo partner.</p>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.partners.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded font-semibold hover:bg-gray-200">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded font-semibold hover:bg-indigo-700">Simpan Partner</button>
        </div>
    </form>
</div>
@endsection