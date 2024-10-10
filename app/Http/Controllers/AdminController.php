<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\Product;

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
        } catch (\Exception $e) {
            return back()->withErrors('Did not find product');
        }
    }

    public function editProduct(Request $request, $id)
    {
        try {
            $request->validate([
              'title' => 'string|max:255',
              'price' => 'numeric|min:0',
              'description' => 'string',
              'image'=> 'image|mimes:png, jpeg, gif, webp, svg, jpg',
            ]);
      
            $product = Product::findOrFail($id);

            if ($request->hasFile('image')) {
                $destination = 'images/' . $product->image_path;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() .'.'. $extension;
                $file->move('images/', $filename);
                $product->image_path = $filename;
            }

            $product->update($request->all());
            return redirect()->route('edit.page')->with('success', 'Product updated');
        } catch (\Exception $e) {
            return back()->withErrors('Product couldnt be edited');
        }
    }

    public function deleteProduct($id){
        try {
            $product = Product::findOrFail($id);
            $product->delete();
    
            return redirect()->route('edit.page')->with('success', 'Product removed');
        } catch (\Exception $e) {
            return back()->withErrors('Product couldnt be removed');
        }
    }
}
