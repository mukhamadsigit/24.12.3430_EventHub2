<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Silakan login terlebih dahulu untuk memberikan ulasan.');
        }

        // Cek apakah acara sudah selesai tuntas (tanggal acara telah berlalu)
        if (!$event->isCompleted()) {
            return back()->with('error', 'Penilaian dan ulasan baru dapat diberikan setelah acara tuntas.');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|min:5|max:1000',
        ], [
            'rating.required' => 'Silakan pilih rating bintang 1 hingga 5.',
            'rating.between' => 'Rating bintang harus bernilai antara 1 sampai 5.',
            'review.required' => 'Kolom ulasan/testimoni tidak boleh kosong.',
            'review.min' => 'Ulasan minimal 5 karakter.',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'event_id' => $event->id,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        return back()->with('success', 'Terima kasih! Ulasan dan rating Anda berhasil disimpan.');
    }
}
