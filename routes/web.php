<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\CategoryController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tentang', function(){
    return view('welcome'); // Temporary, will link to a section or new page
})->name('tentang');

Route::get('/kontak', function(){
    return view('contact');
})->name('kontak');

Route::get('/profil', function(){
    return view('profil');
})->name('profil');

Route::get('/katalog', function(){
    return view('katalog');
})->name('katalog');

Route::get('/bantuan', function(){
    return view('bantuan');
})->name('bantuan');

// Event & Ticket Routes
Route::get('/event/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('event.detail');
Route::get('/checkout', [\App\Http\Controllers\EventController::class, 'checkout'])->name('checkout');
Route::get('/tickets', [\App\Http\Controllers\TicketController::class, 'index'])->name('tickets.index');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', EventController::class);
    Route::resource('categories', CategoryController::class);
});
