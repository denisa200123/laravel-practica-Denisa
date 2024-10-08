<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\AddToCartRequest;
use Session;

class ProductController extends Controller
{
    public function index(Request $request) {
        $this->initializeCart($request);
        
        $products =  Product::notInCart($request);
        return view('products',['products'=>$products]);
    }

    public function store(AddToCartRequest  $request) {
        $this->initializeCart($request);

        $id = $request->id;
        $productsInCart = collect($request->session()->get('productsInCart', []));
        
        if (!$productsInCart->contains($id)) {
            $productsInCart->push($id);
            $request->session()->put('productsInCart', $productsInCart->all());
        }

        return redirect()->route('products.index')->with('success', 'Product added to cart!');
    }

    private function initializeCart(Request $request) {
        if (!$request->session()->has('productsInCart')) {
            $request->session()->put('productsInCart', []);
        }
    }
}
