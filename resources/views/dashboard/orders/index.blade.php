@extends('layouts.admin')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div>
</section>


<!-- SEARCH FORM -->
<form class="form-inline ml-3" method="GET" action="{{ route('dashboard.orders.index') }}">
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

<div class="row">
    <div class="card-body col-md-6">

        {{-- @if (auth()->user()->hasPermission('orders_create'))
    <div class="row">
        <a href=" {{ route('dashboard.orders.create') }} " class="btn btn-primary mb-2">
        <i class="fa fa-plus">Add</i></a>
    </div>
    @else
    <div class="row">
        <a href="#" class="btn btn-primary mb-2 disabled">
            <i class="fa fa-plus">Add</i></a>
    </div>
    @endif --}}




    <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Total Price</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        @if ($orders->count()==0)
        <h1>No Data Found</h1>
        @else
        @foreach ($orders as $order)
        <tr>
            <th>{{ $order->client->name }}</th>
            <th>{{ $order->total_price }}</th>
            <th>{{ date('d-M-Y', strtotime($order->created_at)) }}</th>
            <th>

                <button class="btn btn-primary btn-sm order-products" type="submit"
                    data-url="{{ route('dashboard.order.products', $order->id) }}">
                    <i class="fa fa-search"></i>Show</button>


                @if (auth()->user()->hasPermission('orders_update'))
                <a href=" {{ route('dashboard.orders.edit', $order->id) }} " class="btn btn-info btn-sm"><i
                        class="fa fa-edit"></i> Edit</a>
                @else
                <button class="btn btn-info btn-sm" type="submit" disabled><i class="fa fa-edit"></i> Edit</button>
                @endif

                @if (auth()->user()->hasPermission('orders_delete'))
                <form method="POST" action=" {{ route('dashboard.orders.destroy', $order->id) }} "
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

    {{ $orders->links() }}

</div>

<div class="col-md-4">

    <div class="box box-primary">

        <div class="box-header">
            <h3 class="box-title" style="margin-bottom: 10px">Order Products</h3>
        </div>

        <div class="box-body">

            <div id="order-product-list">

            </div>

        </div>

    </div>

</div>

</div>


@endsection