<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductIdRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

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

    //send mail
    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'comments' => 'required|string',
        ]);

        $productsInCart = $request->session()->get('productsInCart', []);
        $products = Product::whereIn('id', $productsInCart)->get();

        Mail::to("denisa.olaru179@gmail.com")->send(new OrderConfirmation($products, $request->all()));
        $request->session()->forget('productsInCart');

        return redirect()->route('products.index')->with('OrderSuccess', 'Order placed successfully!');
    }

    private function initializeCart(Request $request) {
        if (!$request->session()->has('productsInCart')) {
            $request->session()->put('productsInCart', []);
        }
    }
}
