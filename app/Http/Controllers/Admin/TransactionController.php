<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Transaction::with('event');

        if ($user->role === 'organizer') {
            $query->whereHas('event', function ($q) use ($user) {
                $q->where('organizer_id', $user->id);
            });
        }

        $transactions = $query->latest()->paginate(10);
        return view('admin.transaction', compact('transactions'));
    }
}
