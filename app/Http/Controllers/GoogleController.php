<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite; // Wajib dipanggil untuk login Google
use App\Models\User; // Wajib dipanggil untuk menyimpan ke tabel users
use Illuminate\Support\Facades\Auth; // Wajib dipanggil untuk proses login Laravel

class GoogleController extends Controller
{
    // 1. Fungsi untuk melempar user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Fungsi untuk menangani balasan dari Google setelah user memilih akun
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cari user berdasarkan google_id, atau berdasarkan email jika belum terasosiasi
        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                // Hubungkan google_id ke akun yang sudah ada
                $user->update(['google_id' => $googleUser->id]);
            } else {
                // Buat user baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role' => 'user', // Default role
                ]);
            }
        }

        // Login-kan user ke sistem Laravel
        Auth::login($user);
        
        // Arahkan ke halaman yang sesuai berdasarkan Role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/');
        }
    }
}