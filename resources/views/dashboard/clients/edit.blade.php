@extends('layouts.admin')

@section('title', 'Edit Client')

@section('content')

<section class="content-header mb-5">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Client</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.clients.index') }}">Clients</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Client</h3>
    </div>

    @include('partials._errors')

    <form method="POST" action=" {{ route('dashboard.clients.update', $client) }} ">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" autocomplete="off"
                    value="{{ $client->name }}">
            </div>

            @for ($i = 0; $i < 2; $i++) <div class="form-group">
                <label>Phone {{ $i+1 }}</label>
                <input type="text" name="phone[]" class="form-control" value="{{ $client->phone[$i] ?? '' }}"
                    autocomplete="off">
        </div>
        @endfor

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" autocomplete="off" value="{{ $client->address }}">
        </div>
</div>
<!-- /.card-body -->

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>


@endsection