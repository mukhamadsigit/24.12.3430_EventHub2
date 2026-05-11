@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Kelola Kategori Event')
@section('page_subtitle', 'Gunakan kategori untuk mengelompokkan event Anda.')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Tambah -->
    <div class="lg:col-span-1">
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm sticky top-10">
            <h3 class="font-black text-xl mb-6">Tambah Kategori</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block mb-2 font-bold text-slate-700">Nama Kategori</label>
                    <input type="text" name="name" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition" placeholder="Contoh: Musik, Seminar, dll." required>
                    @error('name')
                        <p class="text-rose-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Simpan Kategori</button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b">
                <h3 class="font-black text-xl">Daftar Kategori</h3>
                <p class="text-slate-500 text-sm font-medium">Total {{ $categories->total() }} kategori aktif</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-4">No</th>
                            <th class="px-8 py-4">Nama Kategori</th>
                            <th class="px-8 py-4">Slug</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y border-t border-slate-50">
                        @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/50 transition group">
                            <td class="px-8 py-6 font-medium text-slate-500">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-bold text-xs">
                                    {{ $category->name }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-slate-400 text-sm">{{ $category->slug }}</td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center gap-2">
                                    <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}')" class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin? Semua event dengan kategori ini akan terpengaruh.')">
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
                            <td colspan="4" class="text-center py-10 text-slate-400">Belum ada kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
            <div class="p-8 border-t bg-slate-50">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl">
        <h3 class="font-black text-xl mb-6">Edit Kategori</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label class="block mb-2 font-bold text-slate-700">Nama Kategori</label>
                <input type="text" name="name" id="editName" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition" required>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeEditModal()" class="flex-1 px-6 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editCategory(id, name) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        const input = document.getElementById('editName');
        
        form.action = `/admin/categories/${id}`;
        input.value = name;
        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection