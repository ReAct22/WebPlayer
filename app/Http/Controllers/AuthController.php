<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function formLogin(){
        return view('pages.login');
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if(!Auth::attempt($credentials)){
            return redirect()->back()->withErrors(['message' => 'Username atau password salah.']);
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'berhasil logout');
    }
}
