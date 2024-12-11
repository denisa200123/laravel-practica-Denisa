<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if ($request->username === env('ADMIN_USERNAME') && $request->password === env('ADMIN_PASSWORD')) {
            Session::put('is_admin', true);
            return redirect()->route('home')->with('success', __('Successfull login!'));
        }

        return back()->withErrors(__('Invalid credentials!'));
    }

    public function logout(Request $request)
    {
        Session::forget('is_admin');
        return redirect()->route('home');
    }
}
