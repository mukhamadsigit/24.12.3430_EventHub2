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
    public function checkout()
    {
        return view('checkout');
    }
    
}

