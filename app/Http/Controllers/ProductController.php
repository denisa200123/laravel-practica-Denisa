<?php

namespace App\Http\Controllers;

use File;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //search product
    public function search(Request $request)
    {
        $request->validate(['searchedProduct' => 'string|max:255|min:1']);
        $name = $request->searchedProduct;

        $products = Product::where('title', 'like', "%$name%")->get();
        if ($products && count($products) > 0 && $name) {
            return view('/products-search', ['products' => $products]);
        }
        return redirect()->route('products.index')->withErrors(__('Product not found'));
    }

    //store product
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'image' => 'required|image',
            ]);

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/', $filename);

            $info = ['title' => $request->title, 'price' => $request->price, 'description' => $request->description, 'image_path' => $filename];

            Product::create($info);
            return redirect()->route('products.index')->with('success', __('Product created'));
        } catch (\Exception $e) {
            return back()->withErrors(__('Product couldnt be created'));
        }
    }

    //edit product
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('products-edit', ['product' => $product]);
        } catch (\Exception $e) {
            return back()->withErrors(__('Did not find product'));
        }
    }

    //update product
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'string|max:255',
                'price' => 'numeric|min:0',
                'description' => 'string',
                'image' => 'image',
            ]);

            $product = Product::findOrFail($id);

            if ($request->hasFile('image')) {
                $destination = 'images/' . $product->image_path;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/', $filename);
                $product->image_path = $filename;
            }

            $product->update($request->all());
            return redirect()->route('products.index')->with('success', __('Product updated'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')->withErrors(__('Product couldnt be edited'));
        }
    }

    //delete product
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.index')->with('success', __('Product removed'));
        } catch (\Exception $e) {
            return back()->withErrors(__('Product couldnt be removed'));
        }
    }

}
