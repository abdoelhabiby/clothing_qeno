<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');

    }


    public function showLogin()
    {
        return view('dashboard.auth.login');
    }


    // ----------------------------------------
    public function login(Request $request)
    {
        $validte = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials =  $request->only(['email','password']);
        $remember = $request->filled('remember_me');


        if(auth()->guard('admin')->attempt($credentials,$remember)){

           return  redirect()->intended('/dashboard');
        }

        $error = \Illuminate\Validation\ValidationException::withMessages([
            'error_data' => ['invalid data']
         ]);

         throw $error;



    }
    // ----------------------------------------

    public function logout(Request $request)
    {

        auth()->guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()->route('dashboard.show_login');
    }

    // ----------------------------------------
}
