<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Public landing page.
     * If an user session exists, 
     * redirect to dashboard to avoid "back to landing after login" .
     * OAKYY YESSS
     * 
     */
    public function index(Request $request)
    {
        // Jika sudah ada session user, langsung ke dashboard
        if ($request->session()->has('user')) {
            return redirect()->route('dashboard');
        }

        // Untuk guest: tampilkan landing (buat file resources/views/landing.blade.php)
        return view('landing');
    }
}
