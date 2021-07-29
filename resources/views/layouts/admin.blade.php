<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('bower_components/admin-lte/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{--noty--}}
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/noty/noty.css') }}">
    <script src="{{ asset('bower_components/admin-lte/plugins/noty/noty.min.js') }}"></script>

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('bower_components/admin-lte/dist/img/user2-160x160.jpg')}}"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{auth()->user()->first_name .' '. auth()->user()->last_name}}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @if (auth()->user()->hasPermission('users_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.users.index') }}" class="nav-link">
                                <p>
                                    Admins
                                </p>
                            </a>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('clients_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.clients.index') }}" class="nav-link">
                                <p>
                                    Clients
                                </p>
                            </a>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('orders_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.orders.index') }}" class="nav-link">
                                <p>
                                    Orders
                                </p>
                            </a>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('products_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.products.index') }}" class="nav-link">
                                <p>
                                    Products
                                </p>
                            </a>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('categories_read'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.categories.index') }}" class="nav-link">
                                <p>
                                    Categories
                                </p>
                            </a>
                        </li>
                        @endif



                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    @yield('title')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                    @yield('content')

                </div>
                @include('partials._session')
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{asset('bower_components/admin-lte/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE -->
    <script src="{{asset('bower_components/admin-lte/dist/js/adminlte.js')}}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{asset('bower_components/admin-lte/plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('bower_components/admin-lte/dist/js/demo.js')}}"></script>
    <script src="{{asset('bower_components/admin-lte/dist/js/pages/dashboard3.js')}}"></script>

    {{-- custom JS --}}
    <script src="{{asset('js/custom.js')}}"></script>

</body>

<script>
    $('.delete').click(function(e){
        var del = $(this);
        e.preventDefault();
        
        var notify = new Noty({  
            text: "Confirm delete?",
            type: "warning",
            killer: true,
            buttons:[
                Noty.button('Yes', 'btn btn-primary btn-md mr-3', function(){
                    del.closest('form').submit();
                }),
                Noty.button('No', 'btn btn-danger btn-md', function(){
                    notify.close();
                })
        ]
        }).show();
    });

    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
        $('.profile-img-preview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
    }

    $(".profile-img").change(function() {
        readURL(this);
    });



</script>

</html>