<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $eventCount = Event::count();
        $categoryCount = Category::count();
        $partnerCount = Partner::count();
        $recentPartners = Partner::latest()->take(5)->get();

        return view('admin.dashboard', compact('eventCount', 'categoryCount', 'partnerCount', 'recentPartners')); 
    }
}