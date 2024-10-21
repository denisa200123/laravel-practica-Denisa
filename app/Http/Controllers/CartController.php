<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\ProductIdRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CartController extends Controller
{ 
    private function initializeCart(Request $request) 
    {
        if (!$request->session()->has('productsInCart')) {
            $request->session()->put('productsInCart', []);
        }
    }

    //list all products that aren't in cart
    public function home(Request $request) 
    {
        $this->initializeCart($request);
        
        $products =  Product::notInCart($request);
        return view('home',['products'=>$products]);
    }

    //add product to cart
    public function addCart(ProductIdRequest  $request) 
    {
        $this->initializeCart($request);

        $id = $request->id;
        $productsInCart = collect($request->session()->get('productsInCart', []));
        
        if (!$productsInCart->contains($id)) {
            $productsInCart->push($id);
            $request->session()->put('productsInCart', $productsInCart->all());
        }

        return redirect()->route('home')->with('success', __('Product added to cart'));
    }

    //see products in cart
    public function cart(Request $request) 
    {
        $this->initializeCart($request);

        $productsInCart = $request->session()->get('productsInCart', []);
        $products = Product::whereIn('id', $productsInCart)->get();

        return view('cart', ['products' => $products]);
    }

    //remove from cart
    public function clearCart(ProductIdRequest $request) 
    {
        $productId = $request->id;
        $productsInCart = $request->session()->get('productsInCart', []);
    
        $productsInCart = array_filter($productsInCart, function ($id) use ($productId) 
        {
            return $id != $productId;
        });
    
        $request->session()->put('productsInCart', $productsInCart);
    
        return redirect()->route('cart')->with('success', __('Product removed'));
    }

    //send mail
    public function checkout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'comments' => 'required|string',
        ]);

        $productsInCart = $request->session()->get('productsInCart', []);
        $products = Product::whereIn('id', $productsInCart)->get();
        $totalPrice = $products->sum('price');

        Mail::to('denisa.olaru179@gmail.com')->send(new OrderConfirmation($products, $request->all()));
        
        $info = ['customer_name' => $request->name, 'contact_details' => $request->details, 'comments' => $request->comments, 'total_price' => $totalPrice];

        Order::create($info);
        
        $request->session()->forget('productsInCart');

        return redirect()->route('home')->with('success',  __('Order placed successfully'));
    }
}
