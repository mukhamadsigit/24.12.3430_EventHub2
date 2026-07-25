<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib ditambahkan agar Auth bisa berjalan

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses data login dari form manual (Email & Password)
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek kecocokan email dan password di database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $role = Auth::user()->role;

            // 3. Redirect berdasarkan Role (Sistem Multi-Tenant)
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/'); // User biasa
            }
        }

        // Jika gagal login (password salah atau email tidak ditemukan)
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}