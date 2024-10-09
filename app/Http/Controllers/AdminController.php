<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductIdRequest;

class AdminController extends Controller
{
    public function editProduct(Request $request){
        $products =  Product::all();
        return view('edit_product',['products'=>$products]);
    }
/*
    public function remove(ProductIdRequest $request){
        $productId = $request->id;

        return view('edit_product',['products'=>$products]);
    }*/
}
