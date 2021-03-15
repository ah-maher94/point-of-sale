<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        $clients = Client::when($request->search, function($query) use ($request){
            return $query->where('name', 'like', '%'.$request->search.'%');
        })->paginate(5);
        return view('dashboard.clients.index', compact('clients'));
    }


    public function create()
    {
        return view('dashboard.clients.create');
    }


    public function store(Request $request)
    {
        $newClient = $request->validate([
            'name' => 'required',
            'phone'=> 'required|array|min:1',
            'phone.0'=> 'required',
            'address' => 'required',
        ]);
        
        $newClient['phone'] = array_filter($request->phone);

        Client::create($newClient);
        session()->flash('success', 'Client added successfully');

        return redirect()->route('dashboard.clients.index');
    }


    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }


    public function update(Request $request, Client $client)
    {
        $updatedClient = $request->validate([
            'name' => 'required',
            'phone'=> 'required|array|min:1',
            'phone.0'=> 'required',
            'address' => 'required',
        ]);

        $updatedClient['phone'] = array_filter($request->phone);

        $client->update($updatedClient);
        session()->flash('success', 'Client updated successfully');

        return redirect()->route('dashboard.clients.index');
    }


    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('dashboard.clients.index');
    }
}
