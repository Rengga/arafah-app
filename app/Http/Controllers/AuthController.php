<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {

            if (auth()->user()->role === 'dokter') {
                return redirect('/doctor/dashboard');
            }

            if (auth()->user()->role === 'apoteker') {
                return redirect('/pharmacist/dashboard');
            }
        }

        return back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}