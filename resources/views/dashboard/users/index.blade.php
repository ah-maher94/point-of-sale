@extends('layouts.admin')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Admins</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Admins</li>
                </ol>
            </div>
        </div>
    </div>
</section>


<!-- SEARCH FORM -->
<form class="form-inline ml-3" method="GET" action="{{ route('dashboard.users.index') }}">
    <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" name="search" placeholder="Search"
            aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>

<div class="card-body">

    @if (auth()->user()->hasPermission('users_create'))
    <div class="row">
        <a href=" {{ route('dashboard.users.create') }} " class="btn btn-primary mb-2">
            <i class="fa fa-plus">Add</i></a>
    </div>
    @else
    <div class="row">
        <a href="#" class="btn btn-primary mb-2 disabled">
            <i class="fa fa-plus">Add</i></a>
    </div>
    @endif




    <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        @if ($users->count()==0)
        <h1>No Data Found</h1>
        @else
        @foreach ($users as $user)
        <tr>
            <th>{{ $user->first_name }}</th>
            <th>{{ $user->last_name }}</th>
            <th>{{ $user->email }}</th>
            <th>
                @if (auth()->user()->hasPermission('users_update'))
                <a href=" {{ route('dashboard.users.edit', $user->id) }} " class="btn btn-info btn-sm"><i
                        class="fa fa-edit"></i> Edit</a>
                @else
                <button class="btn btn-info btn-sm" type="submit" disabled><i class="fa fa-edit"></i> Edit</button>
                @endif

                @if (auth()->user()->hasPermission('users_delete'))
                <form method="POST" action=" {{ route('dashboard.users.destroy', $user->id) }} "
                    style="display: inline-block">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i> Delete</button>
                </form>
                @else
                <button class="btn btn-danger btn-sm" type="submit" disabled><i class="fa fa-trash"></i> Delete</button>
                @endif


            </th>
        </tr>
        @endforeach
        @endif
        <tbody>


        </tbody>
    </table>
</div>

@endsection