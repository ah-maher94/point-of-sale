@extends('layouts.admin')

@section('content')

<section class="content-header mb-5">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">Admins</a></li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add User</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    @include('partials._errors')

    <form method="POST" action=" {{ route('dashboard.users.update', $user->id )}} ">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="First Name" autocomplete="off"
                    value="{{ $user->first_name }}">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" autocomplete="off"
                    value="{{ $user->last_name }}">
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" autocomplete="off"
                    value="{{ $user->email }}">
            </div>

            @php
            $models = ['users', 'categories', 'products'];
            $permissions = ['create', 'read', 'update', 'delete'];
            @endphp

            <div class="col-12 col-sm-6">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            @foreach ($models as $index => $model)
                            <li class="nav-item">
                                <a class="nav-link {{ $index==0 ? 'active' : '' }}" data-toggle="pill"
                                    href="#{{$model}}" role="tab" aria-controls="custom-tabs-one-home"
                                    aria-selected="true">{{ $model }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                            @foreach ($models as $index => $model)
                            <div class="tab-pane fade {{ $index==0 ? 'show active' : '' }}" id="{{$model}}"
                                role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                                @foreach ($permissions as $permission)
                                <div class="form-check mr-3" style="display: inline-block">
                                    <input type="checkbox" class="form-check-input" name="permission[]"
                                        {{$user->hasPermission($model.'_'.$permission) ? 'checked' : ''}}
                                        value="{{ $model . '_' . $permission}}">
                                    <label class="form-check-label">{{$permission}}</label>
                                </div>
                                @endforeach

                            </div>

                            @endforeach

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>


@endsection