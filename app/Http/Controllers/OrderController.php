<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $orders = Order::paginate(5);

            if ($request->expectsJson()) {
                return response()->json($orders);
            }

            return view('orders', ['orders' => $orders]);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => __('No orders to show')], 204);
            }

            return back()->withErrors(__('No orders to show.'));
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            if ($request->expectsJson()) {
                return response()->json($order);
            }

            return view('orders-show', ['order' => $order]);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => __('Did not find order')], 404);
            }

            return back()->withErrors(__('Did not find order'));
        }
    }
}
