<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin' || $user->role === 'admin') {
            // --- DATA MASTER ---
            $eventCount = Event::count();
            $categoryCount = Category::count();
            $partnerCount = Partner::count();
            $recentPartners = Partner::latest()->take(5)->get();

            // --- DATA TRANSAKSI & STATISTIK ---
            $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');
            $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();
            $activeEvents = Event::where('date', '>=', now())->count();
            $pendingOrders = Transaction::where('status', 'pending')->count();
            $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

            return view('admin.dashboard', compact(
                'eventCount', 
                'categoryCount', 
                'partnerCount', 
                'recentPartners',
                'totalRevenue',
                'ticketsSold',
                'activeEvents',
                'pendingOrders',
                'recentTransactions'
            ));
        } 
        
        elseif ($user->role === 'organizer') {
            // --- DATA MASTER PENYELENGGARA ---
            $eventCount = Event::where('organizer_id', $user->id)->count();
            $categoryCount = Category::count(); // Kategori bersifat global
            $partnerCount = Partner::count();   // Partner bersifat global
            $recentPartners = Partner::latest()->take(5)->get();

            // --- DATA TRANSAKSI & STATISTIK PENYELENGGARA ---
            $totalRevenue = Transaction::whereHas('event', function ($query) use ($user) {
                $query->where('organizer_id', $user->id);
            })->whereIn('status', ['settlement', 'success'])->sum('total_price');

            $ticketsSold = Transaction::whereHas('event', function ($query) use ($user) {
                $query->where('organizer_id', $user->id);
            })->whereIn('status', ['settlement', 'success'])->count();

            $activeEvents = Event::where('organizer_id', $user->id)->where('date', '>=', now())->count();

            $pendingOrders = Transaction::whereHas('event', function ($query) use ($user) {
                $query->where('organizer_id', $user->id);
            })->where('status', 'pending')->count();

            $recentTransactions = Transaction::whereHas('event', function ($query) use ($user) {
                $query->where('organizer_id', $user->id);
            })->with('event')->latest()->take(5)->get();

            return view('organizer.dashboard', compact(
                'eventCount', 
                'categoryCount', 
                'partnerCount', 
                'recentPartners',
                'totalRevenue',
                'ticketsSold',
                'activeEvents',
                'pendingOrders',
                'recentTransactions'
            ));
        }

        abort(403);
    }
}