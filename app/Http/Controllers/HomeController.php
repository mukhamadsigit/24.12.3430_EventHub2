<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua jenis kategori untuk tampilan filter tab button
        $categories = Category::all();

        // 2. Buat kueri dasar untuk mengambil event:
        // - Gunakan Eager loading `category`
        // - Hanya tampilkan kegiatan dengan jadwal yang belum kedaluwarsa (>= hari ini)
        $query = Event::with('category')
            ->where('date', '>=', now())
            ->orderBy('date', 'asc');

        // 3. Filter query jika url memiliki parameter pencarian spesifik ?category=...
        if ($request->has('category') && $request->category != '') {
            // Filter berdasarkan properti slug kategori
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 4. Eksekusi query dan kirim data hasilnya ke template Blade
        $events = $query->get();
        $partners = Partner::latest()->get();

        return view('welcome', compact('events', 'categories', 'partners'));
    }

    public function katalog(Request $request)
    {
        $categories = Category::all();
        $query = Event::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $events = $query->orderBy('date', 'asc')->paginate(9);

        return view('katalog', compact('events', 'categories'));
    }
}