<?php

use Illuminate\Support\Facades\Route;

// Import Controllers (Public)
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\EventController as PublicEventController; // Menggunakan Alias
use App\Http\Controllers\CheckoutController;

// Import Controllers (Admin)
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\EventController as AdminEventController; // Menggunakan Alias

// ==========================================
// RUTE PUBLIK (Bebas Akses)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tentang', function() {
    return redirect()->route('home');
})->name('tentang');

Route::get('/kontak', function() {
    return view('contact');
})->name('kontak');

Route::get('/profil', function() {
    return view('profil');
})->name('profil');

Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');

Route::get('/bantuan', function() {
    return view('bantuan');
})->name('bantuan');

// ==========================================
// RUTE EVENT & TICKET
// ==========================================
// Memanggil alias PublicEventController agar kodenya lebih bersih
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');

// Checkout & Payment Routes (Midtrans)
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.callback');

Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

// ==========================================
// RUTE ADMINISTRATOR
// ==========================================
Route::redirect('/admin', '/admin/dashboard');

// Grouping untuk URL berawalan /admin
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute Autentikasi Admin (Bebas Akses)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Mengamankan Route Administrasi di balik tembok (Middleware)
    Route::middleware(['auth', 'admin'])->group(function () {
        
        // Rute Dashboard Utama
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Rute Manajemen Data (Resources)
        Route::resource('events', AdminEventController::class); // Memanggil alias AdminEventController
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class)->except(['show']);
        
        // Rute Transaksi
        Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        
    });
    Route::post('/midtrans/callback',
[\App\Http\Controllers\MidtransWebhookController::class, 'handle']);
});