<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function create(Client $client)
    {
        $categories = Category::with('products')->get();;
        return view('dashboard.clients.orders.create', compact('categories', 'client'));
    }


    public function store(Request $request, Client $client)
    {
        // dd($request->quantities);

        $request->validate([
            'quantities' => 'required|array'
        ]);

        // add new order
        $newOrder = $client->orders()->create();

        // add product order record
        $newOrder->products()->attach($request->quantities);

        $orderTotalPrice = 0;
        foreach ($request->quantities as $productId => $productQuantity) {

            // get product
            $product = Product::findOrFail($productId);

            // calculate total price
            $orderTotalPrice += $product->sale_price * $productQuantity['quantity'];

            // reduce quantity from stock
            $product->update([
                'stock' => $product->stock - $productQuantity['quantity']
            ]);
        }

        // update order total price
        $newOrder->update([
            'total_price' => $orderTotalPrice
        ]);

        return redirect()->route('dashboard.orders.index');
    }

}
