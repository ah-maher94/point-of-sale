@extends('layouts.admin')

@section('title', 'New Order')

@section('content')

<section class="content-header mb-5">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Client</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.clients.index') }}">Clients</a></li>
                    <li class="breadcrumb-item active">Add Order</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Order</h3>
    </div>

    @include('partials._errors')

    <div class="row">

        <div class="col-md-6">

            <div class="box box-primary">

                <div class="box-header">

                    <h3 class="box-title" style="margin-bottom: 10px"></h3>

                </div><!-- end of box header -->

                <div class="box-body">

                    @foreach ($categories as $category)
                    <div class="panel-group">

                        <div class="panel panel-info">

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" class="btn btn-outline-primary ml-3"
                                        href="#{{ str_replace(' ', '-', $category->name) }}">{{ $category->name }}</a>
                                </h4>
                            </div>

                            <div id="{{ str_replace(' ', '-', $category->name) }}" class="panel-collapse collapse">

                                <div class="panel-body">

                                    @if ($category->products->count() > 0)

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Stock</th>
                                                <th>Price</th>
                                                <th>Add</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($category->products as $product)
                                            <tr>
                                                <th>{{ $product->name }}</th>
                                                <th>{{ $product->stock }}</th>
                                                <th>{{ $product->sale_price }}</th>
                                                <th>
                                                    <button class="btn btn-success btn-sm add-order-product"
                                                        id="product-{{ $product->id }}" data-id="{{ $product->id }}"
                                                        data-name="{{ $product->name }}"
                                                        data-price="{{ $product->sale_price }}">Add</button>
                                                </th>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><!-- end of table -->

                                    @else
                                    <h5>No products</h5>
                                    @endif

                                </div><!-- end of panel body -->

                            </div><!-- end of panel collapse -->

                        </div><!-- end of panel primary -->

                    </div><!-- end of panel group -->

                    @endforeach

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </div><!-- end of col -->

        <div class="col-md-6">

            <div class="box box-primary">

                <div class="box-header">

                    <h3 class="box-title"></h3>

                </div><!-- end of box header -->

                <div class="box-body">

                    <form action="{{ route('dashboard.client.orders.store', $client->id) }}" method="POST">

                        {{ csrf_field() }}
                        {{ method_field('POST') }}

                        @include('partials._errors')

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>

                            <tbody class="order-list">


                            </tbody>

                        </table><!-- end of table -->

                        <h4>Total : <span class="total-price">0</span></h4>

                        <button class="btn btn-primary btn-block" id="add-order-form-btn" disabled><i
                                class="fa fa-plus"></i>
                        </button>

                    </form>

                </div><!-- end of box body -->

            </div><!-- end of box -->



        </div><!-- end of col -->

    </div><!-- end of row -->


</div>


@endsection