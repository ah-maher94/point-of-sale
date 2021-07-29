@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')

<section class="content-header mb-5">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Product</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    @include('partials._errors')

    <form method="POST" action=" {{ route('dashboard.products.update', $product->id )}} " enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="card-body">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id">
                        @foreach ($categories as $category)
                        @if ($category->id === $product->category_id)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Product Name" autocomplete="off"
                        value="{{ $product->name }}">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" placeholder="Description">
                        {{ $product->description }}
                    </textarea>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="profile-img">
                </div>
                <div class="form-group">
                    <img src="{{ asset('uploads/products/'.$product->image) }}"
                        class="img-thumbnail profile-img-preview" style="width:100px;">
                </div>
                <div class="form-group">
                    <label>Purchase Price</label>
                    <input type="number" min="0" step="0.1" name="purchase_price" class="form-control"
                        value="{{ $product->purchase_price }}">
                </div>
                <div class="form-group">
                    <label>Sale Price</label>
                    <input type="number" min="0" step="0.1" name="sale_price" class="form-control"
                        value="{{ $product->sale_price }}">
                </div>
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" min="0" step="1" name="stock" class="form-control"
                        value="{{ $product->stock }}">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
    </form>
</div>


@endsection