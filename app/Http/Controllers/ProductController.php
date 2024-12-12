<?php

namespace App\Http\Controllers;

use File;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function saveImage($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move('images/', $filename);

        return $filename;
    }

    //display all products
    public function index(Request $request)
    {
        $request->validate([
            'orderBy' => 'string|in:title,price,description,none',
            'searchedProduct' => 'nullable|string|max:255'
        ]);

        $orderBy = $request->input('orderBy');
        $searchedProduct = $request->input('searchedProduct');
        $query = Product::query();

        if (!empty($searchedProduct)) {
            $query->where('title', 'like', "%{$searchedProduct}%");
        }

        if ($orderBy !== 'none' && !empty($orderBy)) {
            $query->orderBy($orderBy, 'asc');
        }

        $products = $query->paginate(2)->appends([
            'searchedProduct' => $searchedProduct,
            'orderBy' => $orderBy
        ]);
        return view('products', ['products' => $products]);
    }

    //show product
    public function show($id = null)
    {
        try {
            if (is_null($id)) {
                return view('products-create');
            }

            $product = Product::findOrFail($id);

            return view('products-edit', ['product' => $product]);
        } catch (\Exception $e) {
            return back()->withErrors(__('Did not find product'));
        }
    }

    //store product
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'image' => 'required|image',
            ]);

            $filename = $this->saveImage($request->file('image'));

            $info = [
                'title' => $request->title,
                'price' => $request->price,
                'description' => $request->description,
                'image_path' => $filename
            ];

            Product::create($info);
            return redirect()->route('products.index')->with('success', __('Product created'));
        } catch (\Exception $e) {
            return back()->withErrors(__('Product couldnt be created'));
        }
    }

    //update product
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'string|max:255',
                'price' => 'numeric|min:0',
                'image' => 'image',
            ]);

            $product = Product::findOrFail($id);

            if ($request->hasFile('image')) {
                $destination = 'images/' . $product->image_path;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $filename = $this->saveImage($request->file('image'));
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
