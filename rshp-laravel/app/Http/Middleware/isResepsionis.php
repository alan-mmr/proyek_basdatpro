<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isResepsionis
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $roleName = $user->roles->first()->nama_role ?? '';

        // Cek Keyword 'Resepsionis'
        if (stripos($roleName, 'Resepsionis') !== false) {
            return $next($request);
        }

        abort(403, 'AKSES DITOLAK. Khusus Resepsionis.');
    }
}