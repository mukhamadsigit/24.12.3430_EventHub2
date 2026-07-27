<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerProfileController extends Controller
{
    public function show(Partner $partner)
    {
        // Load event milik partner & ulasannya
        $events = $partner->events()->with('category')->withCount('reviews')->latest()->get();
        $reviews = $partner->reviews()->with(['user', 'event'])->latest()->paginate(10);
        $averageRating = $partner->averageRating();
        $totalReviews = $partner->totalReviews();
        $ratingBreakdown = $partner->ratingBreakdown();

        // Kategori untuk menu/footer jika ada
        $categories = \App\Models\Category::all();

        return view('partner-detail', compact(
            'partner',
            'events',
            'reviews',
            'averageRating',
            'totalReviews',
            'ratingBreakdown',
            'categories'
        ));
    }
}
