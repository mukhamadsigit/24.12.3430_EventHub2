<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $transaction = null;
        if ($request->has('id')) {
            $transaction = Transaction::with('event')->find($request->id)
                ?? Transaction::with('event')->where('order_id', $request->id)->first();
        }
        return view('ticket', compact('transaction'));
    }
}
