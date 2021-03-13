<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::paginate(5);
        return view('dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required',
            'image' => 'image',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required|numeric',
        ]);
        
        $request_data = $request->all();
        if($request->image){
            Image::make($request->image)->resize(300, null, function($constrain){
                $constrain->aspectRatio();
            })->save(public_path('uploads/products/'.$request->image->hashName()));
        }
        $request_data['image'] = $request->image->hashName();

        // dd($request_data);
        Product::create($request_data);
        session()->flash('success', 'Product added successfully');

        return redirect()->route('dashboard.products.index');


    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact(['product', 'categories']));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required',
            'image' => 'image',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required|numeric',
        ]);

        $request_data = $request->except(['image']);

        if($request->image){
            if($product->image != "default.jpg"){
                Storage::disk('public_uploads')->delete('/products/'.$product->image);
            }
            Image::make($request->image)->resize(300, null, function($constrain){
                $constrain->aspectRatio();
            })->save(public_path('uploads/products/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();

        }

        $product->update($request_data);

        session()->flash('success', 'Product updated successfully');
        return redirect()->route('dashboard.products.index');

    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.products.index');
    }
}
