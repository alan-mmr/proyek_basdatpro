<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isPerawat
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $roleName = $user->roles->first()->nama_role ?? '';

        // Cek Keyword 'Perawat'
        if (stripos($roleName, 'Perawat') !== false) {
            return $next($request);
        }

        abort(403, 'AKSES DITOLAK. Khusus Perawat.');
    }
}