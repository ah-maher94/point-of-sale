@extends('layouts.admin')

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
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Client</h3>
    </div>

    @include('partials._errors')

    <form method="POST" action=" {{ route('dashboard.clients.store') }} ">
        @csrf
        @method('POST')

        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" autocomplete="off"
                    value="{{ old('name') }}">
            </div>

            @for ($i = 0; $i < 2; $i++) <div class="form-group">
                <label>Phone {{ $i+1 }}</label>
                <input type="text" name="phone[]" class="form-control" value="{{ old('phone.'.$i) }}"
                    autocomplete="off">
        </div>
        @endfor

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" placeholder="Address" autocomplete="off"
                value="{{ old('address') }}">
        </div>
</div>
<!-- /.card-body -->

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>


@endsection