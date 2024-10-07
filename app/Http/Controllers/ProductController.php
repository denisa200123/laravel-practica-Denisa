<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products =  Product::notInCart($request);
        return view('products',['products'=>$products]);
    }

    public function post(Request $request) {
        $id = $request->id;
        if (!$request->session()->has('productsInCart')) {
            $request->session()->put('productsInCart', []);
        }

        $request->session()->push('productsInCart', $id);
        Session::get('productsInCart')->unique();
        return view('products');
    }
}
