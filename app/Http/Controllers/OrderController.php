<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showOrders(Request $request) 
    {
        $orders =  Order::all();
        return view('orders',['orders'=>$orders]);
    }
}
