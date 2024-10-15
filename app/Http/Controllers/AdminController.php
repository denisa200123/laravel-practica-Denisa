<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function editPage(Request $request)
    {
        $products =  Product::all();
        return view('edit_page',['products'=>$products]);
    }

    public function editProductPage($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('edit_product',['product'=>$product]);
        } catch (\Exception $e) {
            return back()->withErrors(__('Did not find product'));
        }
    }

    public function editProduct(Request $request, $id)
    {
        try {
            $request->validate([
              'title' => 'string|max:255',
              'price' => 'numeric|min:0',
              'description' => 'string',
              'image'=> 'image',
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
            return redirect()->route('edit.page')->with('success', __('Product updated'));
        } catch (\Exception $e) {
            return redirect()->route('edit.page')->withErrors(__('Product couldnt be edited'));
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
    
            return redirect()->route('edit.page')->with('success', __('Product removed'));
        } catch (\Exception $e) {
            return back()->withErrors(__('Product couldnt be removed'));
        }
    }

    public function addProductPage(Request $request)
    {
        return view('add_product');
    }

    public function addProduct(Request $request)
    {
        try {
            $request->validate([
              'title' => 'required|string|max:255',
              'price' => 'required|numeric|min:0',
              'description' => 'required|string',
              'image'=> 'required|image',
            ]);

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/', $filename);

            $info = ['title' => $request->title, 'price' => $request->price, 'description' => $request->description, 'image_path' =>$filename];

            Product::create($info);
            return redirect()->route('edit.page')->with('success', __('Product created'));
        } catch (\Exception $e) {
            return back()->withErrors(__('Product couldnt be created'));
        }
        
    }
}
