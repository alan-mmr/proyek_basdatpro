<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(Request $r)
{
    $r->validate(['username' => 'required', 'password' => 'required']);
    $u = \Illuminate\Support\Facades\DB::table('view_user_role')->where('username', $r->username)->first();

    if (!$u || $r->password !== $u->password) {
        return back()->withErrors(['login' => 'Credentials not valid'])->withInput();
    }

    // regenerate session to avoid fixation / ensure persistence
    $r->session()->regenerate();

    $r->session()->put('user', [
        'iduser'    => $u->iduser,
        'username'  => $u->username,
        'nama_role' => $u->nama_role,
        'idrole'    => $u->idrole,
    ]);

    // Redirect to intended URL or dashboard
    return redirect()->intended(route('dashboard'));
}

    public function logout(Request $r)
    {
        $r->session()->forget('user');
        return redirect('/login')->with('success', 'Logged out');
    }
}
