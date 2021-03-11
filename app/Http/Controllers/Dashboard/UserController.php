<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{


    public function __construct(){
        $this->middleware('permission:users_read')->only('index');
        $this->middleware('permission:users_create')->only('create');
        $this->middleware('permission:users_update')->only('edit');
        $this->middleware('permission:users_delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::when($request->search, function($query) use ($request){
            return $query->where('first_name', 'like', '%'.$request->search.'%')
            ->orWhere('last_name', 'like', '%'.$request->search.'%');
        })->whereRoleIs('admin')->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);

        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/images/'.$request->image->hashName()));
        }


        $request_data = $request->except(['password', 'password_confirmation', 'permission', 'image']);
        $request_data['password'] = bcrypt($request->password);
        $request_data['image'] = $request->image->hashName();

        
        $user = User::create($request_data);
        $user->attachRole('admin'); 
        $user->syncPermissions($request->permission);

        session()->flash('success', ('User added successfully'));
        return redirect()->route('dashboard.users.index');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        $request_data = $request->except(['permission']);
        $user->update($request_data);
        $user->syncPermissions($request->permission);

        session()->flash('success', ('User updated successfully'));
        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->image != "default.jpg"){
            Storage::disk('public_uploads')->delete("/images/". $user->image);
        }
        $user->delete();
        return redirect()->route('dashboard.users.index');
    }
}
