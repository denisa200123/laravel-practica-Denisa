<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Session;

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
}
