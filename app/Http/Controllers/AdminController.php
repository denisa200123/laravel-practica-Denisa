<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function editPage(Request $request){
        $products =  Product::all();
        return view('edit_page',['products'=>$products]);
    }

    public function editProductPage($id){
        try {
            $product = Product::findOrFail($id);

            return view('edit_product',['product'=>$product]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('edit.page')->with('EditFail', 'Did not find product');
        }
    }

    public function editProduct(Request $request, $id)
    {
        try {
            $request->validate([
              'title' => 'max:255',
              'price' => '',
              'description' => '',
            ]);
      
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return redirect()->route('edit.page')->with('EditSuccess', 'Product updated');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('edit.page')->with('EditProductFail', 'Product couldnt be edited');
        }
    }

    public function deleteProduct($id){
        try {
            $product = Product::findOrFail($id);
            $product->delete();
    
            return redirect()->route('edit.page')->with('DeleteSuccess', 'Product removed');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('edit.page')->with('DeleteFail', 'Product couldnt be removed');
        }
    }
}
