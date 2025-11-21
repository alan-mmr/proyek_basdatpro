<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Ambil data User yang sedang login
        $user = Auth::user();

        // 2. Cek Role-nya apa?
        // (Kita ambil role pertama dari relasi roles)
        $role = $user->roles->first()->nama_role ?? '';

        // 3. Polisi Lalu Lintas (Redirect sesuai Role)
        switch ($role) {
            case 'Administrator':
                return redirect()->route('admin.dashboard');
                break;

            case 'Dokter':
                return redirect()->route('dokter.dashboard');
                break;

            case 'Perawat':
                return redirect()->route('perawat.dashboard');
                break;

            case 'Resepsionis':
                return redirect()->route('resepsionis.dashboard');
                break;
            
            case 'Pemilik':
                return redirect()->route('pemilik.dashboard');
                break;

            default:
                // Kalau role tidak dikenali, baru tampilkan halaman default yang tadi
                return view('home'); 
                break;
        }
    }
}