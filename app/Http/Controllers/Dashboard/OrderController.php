<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){

        $orders = Order::paginate(5);
        return view('dashboard.orders.index', compact('orders'));

    }


    public function destroy(Order $order){

        foreach ($order->products as $product) {
            $product->update([
                'stock'=> $product->stock + $product->pivot->quantity
            ]);
        }

        $order->delete();
        session()->flash('success', 'Order deleted');

        return redirect()->route('dashboard.orders.index');
    }


    public function getProducts(Order $order){
        $products = $order->products;

        return view('dashboard.orders._products', compact('order', 'products'));
    }


}
