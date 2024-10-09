<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLogin(Request $request) {
        if(session("is_admin")) {
            return redirect()->route('products.index');
        }
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if($request->username === env('ADMIN_USERNAME') && $request->password === env('ADMIN_PASSWORD')) {
            $request->session()->put('is_admin', true);
            return redirect()->route('products.index')->with('LoginSuccess', 'Login successfull!');
        }

        return back()->withErrors('Invalid credentials!');
    }

    public function logout(Request $request) {
        if(session("is_admin")) {
            $request->session()->forget('is_admin');
            return redirect()->route('products.index');
        }
        return redirect()->route('products.index');
    }
}
