<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        return view('event-detail', compact('event'));
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

    
}

