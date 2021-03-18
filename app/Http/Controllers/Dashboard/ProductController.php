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
        $categories = Category::all();
        $products = Product::when($request->search, function($query) use ($request){
            return $query->where('name', 'like', '%'.$request->search.'%');
        })->when($request->category_id, function($query) use ($request){
            return $query->where('category_id', $request->category_id);
        })->latest()->paginate(5);

        return view('dashboard.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products,name',
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
            $request_data['image'] = $request->image->hashName();
        }

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
            'name' => 'required|min:3|unique:products,name,'.$product->id,
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
        Storage::disk('public_uploads')->delete('/products/'. $product->image);
        $product->delete();
        return redirect()->route('dashboard.products.index');
    }
}
