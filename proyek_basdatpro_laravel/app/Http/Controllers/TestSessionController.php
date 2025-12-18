<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestSessionController extends Controller
{
    // set session quickly based on view_user_role table (dev only)
    public function setSession($iduser)
    {
        $u = DB::table('view_user_role')->where('iduser', $iduser)->first();
        if (!$u) {
            return redirect('/')->with('error', 'user not found');
        }
        session([
            'user' => [
                'iduser'    => $u->iduser,
                'username'  => $u->username,
                'nama_role' => $u->nama_role,
                'idrole'    => $u->idrole,
            ]
        ]);
        return redirect('/')->with('success', 'session set for ' . $u->username);
    }

    public function clear()
    {
        session()->forget('user');
        return redirect('/')->with('success', 'session cleared');
    }
}
