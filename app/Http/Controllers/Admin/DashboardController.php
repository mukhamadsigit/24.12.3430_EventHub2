<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengarahkan ke file resources/views/admin/dashboard.blade.php
        return view('admin.dashboard'); 
    }
}