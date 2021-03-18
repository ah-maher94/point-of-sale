<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        //
    }


    public function create(Client $client)
    {
        $categories = Category::with('products')->get();;
        return view('dashboard.clients.orders.create', compact('categories', 'client'));
    }


    public function store(Request $request, Client $client)
    {
        //
    }


    public function edit(Order $order)
    {
        //
    }


    public function update(Request $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        //
    }
}
