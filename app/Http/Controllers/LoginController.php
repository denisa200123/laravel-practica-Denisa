<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    public function loginForm(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json();
        }
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

            if ($request->expectsJson()) {
                return response()->json(['success' => __('Successfull login!')]);
            }

            return redirect()->route('home')->with('success', __('Successfull login!'));
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => __('Invalid credentials!')], 401);
        }

        return back()->withErrors(__('Invalid credentials!'));
    }

    public function logout(Request $request)
    {
        Session::forget('is_admin');

        if ($request->expectsJson()) {
            return response()->json(['success' => __('Successfull logout!')]);
        }

        return redirect()->route('home');
    }
}
