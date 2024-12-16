<?php

namespace App\Http\Controllers;

use File;

class SpaController extends Controller
{
    public function index()
    {
        return view('spa');
    }

    public function header()
    {
        return view('components/header-spa')->render();
    }

    public function translations()
    {
        $locale = session('locale');

        $translations = File::json(base_path('lang/en.json'));

        if (in_array($locale, ['ro', 'en', 'es'])) {
            $translations = File::json(base_path("lang/$locale.json"));
        }

        return response()->json($translations);
    }
}
