<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function show(Event $event)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        // Ambil ulasan dari user yang sedang login untuk event ini
        $myReview = null;
        if (auth()->check()) {
            $myReview = \App\Models\Review::where('user_id', auth()->id())
                ->where('event_id', $event->id)
                ->first();
        }

        // Me-render view dengan membawa data kategori dan data spesifik acara tersebut
        return view('event-detail', compact('categories', 'event', 'myReview'));
    }

    public function checkout(Request $request)
    {
        $event = null;
        if ($request->has('event_id')) {
            $event = Event::find($request->event_id);
        }
        if (!$event) {
            $event = Event::first();
        }
        return view('checkout', compact('event'));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'event_id'       => 'required|exists:events,id',
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        $event = Event::findOrFail($request->event_id);
        $totalPrice = $event->price == 0 ? 0 : ($event->price + 5000);

        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => 'TRX-' . rand(10000, 99999),
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => $event->price == 0 ? 'success' : 'pending',
            'snap_token'     => Str::random(20),
        ]);

        return response()->json([
            'success' => true,
            'transaction' => $transaction,
        ]);
    }
}
