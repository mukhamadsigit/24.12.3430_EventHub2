<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $transaction = null;
        $searchId = $request->query('order_id') ?? $request->query('id');

        if ($searchId) {
            $transaction = Transaction::with('event')->where('order_id', $searchId)->first()
                ?? Transaction::with('event')->find($searchId);
        }

        if (!$transaction) {
            $transaction = Transaction::with('event')->where('status', 'success')->latest()->first();
        }

        return view('ticket', compact('transaction'));
    }
}
