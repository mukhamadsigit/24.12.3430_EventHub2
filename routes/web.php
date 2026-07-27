<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// IMPORT CONTROLLERS (PUBLIK & GLOBAL)
// ==========================================
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\EventController as PublicEventController; // Alias
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AuthController; // Controller untuk Login Multi-Tenant & Publik
use App\Http\Controllers\MidtransWebhookController;

// ==========================================
// IMPORT CONTROLLERS (ADMIN)
// ==========================================
// WAJIB pakai alias agar tidak bentrok dengan AuthController milik Publik di atas
use App\Http\Controllers\Admin\AuthController as AdminAuthController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\EventController as AdminEventController; // Alias

// ==========================================
// RUTE AUTENTIKASI (Login Manual & SSO Google)
// ==========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


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


use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PartnerProfileController;

// ==========================================
// RUTE EVENT & TICKET & REVIEWS
// ==========================================
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/reviews', [ReviewController::class, 'store'])->name('events.reviews.store')->middleware('auth');

// Profil Penyelenggara / Partner
Route::get('/partners/{partner}', [PartnerProfileController::class, 'show'])->name('partners.show');

// Checkout & Payment Routes (Midtrans)
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle'])->name('midtrans.callback');

Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');


// ==========================================
// RUTE ADMINISTRATOR
// ==========================================
Route::redirect('/admin', '/admin/dashboard');

// Grouping untuk URL berawalan /admin
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute Autentikasi Admin (Memanggil alias AdminAuthController)
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Mengamankan Route Administrasi di balik tembok (Middleware)
    Route::middleware(['auth', 'admin'])->group(function () {
        
        // Rute Dashboard Utama
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Rute Manajemen Data (Resources)
        Route::resource('events', AdminEventController::class);
        Route::resource('categories', CategoryController::class)->middleware('role:admin,superadmin');
        Route::resource('partners', PartnerController::class)->except(['show'])->middleware('role:admin,superadmin');
        
        // Rute Transaksi
        Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        
    });
});

// ==========================================
// RUTE HELPER PEMELIHARAAN HOSTING (Bisa Dihapus Nanti)
// ==========================================
Route::get('/clear-config', function() {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return "Cache dan konfigurasi berhasil dibersihkan!";
});

Route::get('/link-storage', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    if (!file_exists($linkFolder)) {
        symlink($targetFolder, $linkFolder);
        return 'Storage link berhasil dibuat secara manual!';
    }
    return 'Storage link sudah ada.';
});