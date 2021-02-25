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



<div class="card-body">

    <div class="row">
        <a href=" {{ route('dashboard.users.create') }} " class="btn btn-primary mb-2"><i class="fa fa-plus">
                Add</i></a>
    </div>



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
                <a href=" {{ route('dashboard.users.edit', $user->id) }} " class="btn btn-info btn-sm">Edit</a>
                <form method="POST" action=" {{ route('dashboard.users.destroy', $user->id) }} "
                    style="display: inline-block">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form>
            </th>
        </tr>
        @endforeach
        @endif
        <tbody>


        </tbody>
    </table>
</div>

@endsection