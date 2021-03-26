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
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create', compact('categories', 'client'));
    }


    public function store(Request $request, Client $client)
    {
        
        $this->attach_order($request, $client);

        return redirect()->route('dashboard.orders.index');
    }


    public function edit(Client $client, Order $order){

        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.edit', compact('order', 'categories', 'client'));
    }

    public function update(Request $request, Client $client, Order $order){

        $this->detach_order($order);

        $this->attach_order($request, $client);

        session()->flash('success', 'Order Updated');
        return redirect()->route('dashboard.orders.index');
    }



    private function attach_order($request, $client){
        
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
    }


    private function detach_order($order){

        foreach ($order->products as $product) {
            $product->update([
                'stock'=> $product->stock + $product->pivot->quantity
            ]);
        }

        $order->delete();

    }

}
