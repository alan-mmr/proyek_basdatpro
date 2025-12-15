<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isPemilik
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil User & Role Langsung dari Database (LEBIH STABIL DRPD SESSION)
        $user = Auth::user();
        
        // Ambil nama role (Pake cara yang sama kayak di ProfileController)
        // Asumsi relasi user->roles->first() ada
        $roleName = $user->roles->first()->nama_role ?? '';

        // 3. Cek apakah role mengandung kata "Pemilik" (Case Insensitive)
        if (stripos($roleName, 'Pemilik') !== false) {
            return $next($request);
        }

        // 4. JIKA BUKAN PEMILIK:
        // PENTING: Jangan redirect ke route('dashboard') atau 'home', nanti LOOPING lagi!
        // Lebih baik kasih error 403 (Forbidden)
        abort(403, 'AKSES DITOLAK. Halaman ini khusus Pemilik.');
    }
}