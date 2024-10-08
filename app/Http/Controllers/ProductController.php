<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductIdRequest;
use Session;

class ProductController extends Controller
{
    //see products not added to the cart
    public function index(Request $request) {
        $this->initializeCart($request);
        
        $products =  Product::notInCart($request);
        return view('products',['products'=>$products]);
    }

    //add product to cart
    public function store(ProductIdRequest  $request) {
        $this->initializeCart($request);

        $id = $request->id;
        $productsInCart = collect($request->session()->get('productsInCart', []));
        
        if (!$productsInCart->contains($id)) {
            $productsInCart->push($id);
            $request->session()->put('productsInCart', $productsInCart->all());
        }

        return redirect()->route('products.index')->with('success', 'Product added to cart');
    }

    //see products in cart
    public function cart(Request $request) {
        $this->initializeCart($request);

        $productsInCart = $request->session()->get('productsInCart', []);
        $products = Product::whereIn('id', $productsInCart)->get();

        return view('cart', ['products' => $products]);
    }

    //remove from cart
    public function clearCart(ProductIdRequest $request) {
        $productId = $request->id;
        $productsInCart = $request->session()->get('productsInCart', []);
    
        $productsInCart = array_filter($productsInCart, function ($id) use ($productId) {
            return $id != $productId;
        });
    
        $request->session()->put('productsInCart', $productsInCart);
    
        return redirect()->route('cart')->with('success', 'Product removed');
    }
    

    private function initializeCart(Request $request) {
        if (!$request->session()->has('productsInCart')) {
            $request->session()->put('productsInCart', []);
        }
    }
}
