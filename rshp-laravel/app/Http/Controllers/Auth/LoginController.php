<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba Login
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // 3. Cek Role & Redirect
            $user = Auth::user();
            // Ambil role pertama, jika error/kosong default ke 0
            $roleId = $user->roles->first()->idrole ?? 0; 

            switch ($roleId) {
                case 1: return redirect()->route('admin.dashboard');
                case 2: return redirect()->route('dokter.dashboard');
                case 3: return redirect()->route('perawat.dashboard');
                case 4: return redirect()->route('resepsionis.dashboard');
                case 5: return redirect()->route('pemilik.dashboard');
                default: return redirect()->route('home');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}