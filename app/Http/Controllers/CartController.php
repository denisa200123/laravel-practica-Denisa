<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use Session;

class CartController extends Controller
{ 
    private function initializeCart(Request $request)
    {
        if (!Session::has('products_in_cart')) {
            Session::put('products_in_cart', []);
        }
    }

    //list all products that aren't in cart
    public function home(Request $request)
    {
        $this->initializeCart($request);

        $productsInCart = Session::get('products_in_cart', []);
        $products = Product::whereNotIn('id', $productsInCart)->paginate(3);

        return view('home',['products' => $products]);
    }

    //see products in cart
    public function cart(Request $request)
    {
        $this->initializeCart($request);

        $productsInCart = Session::get('products_in_cart', []);
        $products = Product::whereIn('id', $productsInCart)->get();

        return view('cart', ['products' => $products]);
    }

    //add product to cart
    public function addToCart(Request $request, $id)
    {
        try {
            $this->initializeCart($request);
            $productsInCart = Session::get('products_in_cart', []);

            if (!in_array($id, $productsInCart)) {
                $productsInCart[] = $id;
                Session::put('products_in_cart', $productsInCart);
            }
            return redirect()->route('home')->with('success', __('Product added to cart'));
        } catch (\Exception $e) {
            return back()->withErrors(__('The selected product does not exist'));
        }
    }

    //remove from cart
    public function removeFromCart(Request $request, $id)
    {
        try {
            $this->initializeCart($request);
            $productsInCart = Session::get('products_in_cart', []);

            if (($key = array_search($id, $productsInCart)) !== false) {
                unset($productsInCart[$key]);
                $productsInCart = array_values($productsInCart);
                Session::put('products_in_cart', $productsInCart);
            }

            return redirect()->route('cart')->with('success', __('Product removed'));
        } catch (\Exception $e) {
            return back()->withErrors(__('The selected product does not exist'));
        }
    }

    //send mail
    public function checkout(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'details' => 'required|string',
            ]);

            $productsInCart = Session::get('products_in_cart', []);
            $products = Product::whereIn('id', $productsInCart)->get();
            $totalPrice = $products->sum('price');

            if (!empty(env('USER_EMAIL'))) {
                Mail::to(env('USER_EMAIL'))->send(new OrderConfirmation($productsInCart, $request->all()));
            }

            $order = Order::create([
                'customer_name' => $request->name,
                'contact_details' => $request->details,
                'comments' => $request->comments,
                'total_price' => $totalPrice
            ]);

            if ($products->isNotEmpty()) {
                $order->products()->attach($products);
            }

            Session::forget('products_in_cart');

            return redirect()->route('home')->with('success', __('Order placed successfully'));
        } catch (\Exception $e) {
            return back()->withErrors(__('Mail could not be sent'));
        }
    }
}
