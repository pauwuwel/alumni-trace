<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login.index');
    }

    public function loggingin(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
        ];

        if (Auth::attempt($credentials)) {
            // $user = Auth::user();
            return redirect('/dashboard')->with('_token', Session::token());

        }

        return redirect()->back();
    }

    function loggingout()
    {
        Auth::logout();
        Session::regenerateToken();
        return redirect('/');
    }
}
