@extends('layouts.admin')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </div>
        </div>
    </div>
</section>


<!-- SEARCH FORM -->
<form class="form-inline ml-3" method="GET" action="{{ route('dashboard.products.index') }}">
    <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" name="search" placeholder="Search"
            aria-label="Search" value="{{ request()->search }}">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>

<div class="card-body">

    @if (auth()->user()->hasPermission('products_create'))
    <div class="row">
        <a href=" {{ route('dashboard.products.create') }} " class="btn btn-primary mb-2">
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
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Purchase Price</th>
                <th>Sale Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        @if ($products->count()==0)
        <h1>No Data Found</h1>
        @else
        @foreach ($products as $product)
        <tr>
            <th>{{ $product->name }}</th>
            <th>{{ $product->description }}</th>
            <th>
                <img src="{{ asset('uploads/products/'.$product->image) }}" style="width:100px" class="img-thumbnail">
            </th>
            <th>{{ $product->purchase_price }}</th>
            <th>{{ $product->sale_price }}</th>
            <th>{{ $product->stock }}</th>

            <th>
                @if (auth()->user()->hasPermission('products_update'))
                <a href=" {{ route('dashboard.products.edit', $product->id) }} " class="btn btn-info btn-sm"><i
                        class="fa fa-edit"></i> Edit</a>
                @else
                <button class="btn btn-info btn-sm" type="submit" disabled><i class="fa fa-edit"></i> Edit</button>
                @endif

                @if (auth()->user()->hasPermission('products_delete'))
                <form method="POST" action=" {{ route('dashboard.products.destroy', $product->id) }} "
                    style="display: inline-block">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger btn-sm delete" type="submit">
                        <i class="fa fa-trash"></i>Delete</button>
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

    {{ $products->appends(request()->query())->links() }}

</div>

@endsection