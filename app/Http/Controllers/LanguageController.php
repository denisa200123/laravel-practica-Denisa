<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Session;

class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
        $locale = $request->input('locale');

        if (in_array($locale, ['ro', 'en', 'es'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);

            if ($request->expectsJson()) {
                return response()->json();
            }
        }

        return redirect()->back();
    }
}
