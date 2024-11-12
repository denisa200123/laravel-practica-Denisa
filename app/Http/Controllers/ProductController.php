<?php

namespace App\Http\Controllers;

use File;
use App\Models\Product;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{
    //display all products
    public function index(Request $request)
    {
        $request->session()->forget('name');
        $request->session()->forget('orderBy');
        $products = Product::paginate(2);
        return view('products', ['products' => $products]);
    }

    public function order(Request $request)
    {
        $request->validate([
            'orderBy' => 'string|max:20|min:1|in:title,price,description,none',
            'searchedProduct' => 'string|max:255|min:1'
        ]);

        $orderBy = $request->input('orderBy');
        $name = $request->input('searchedProduct');
        $query = Product::query();

        if ($name) {
            Session::put('name', $name);
        }

        if ($orderBy) {
            Session::put('orderBy', $orderBy);
        }

        if (!empty(Session::get('name'))) {
            $query->where('title', 'like', '%' . Session::get('name') . '%');
        }

        if (Session::get('orderBy') !== 'none' && !empty(Session::get('orderBy'))) {
            $query->orderBy(Session::get('orderBy'), 'asc');
        }

        $products = $query->paginate(2)->appends([
            'searchedProduct' => $name,
            'orderBy' => $orderBy
        ]);
        return view('products', ['products' => $products]);
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
