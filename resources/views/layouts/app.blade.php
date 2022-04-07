<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="userId" content="{{ auth()->check() ? auth()->id() : '' }}">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link href="{{ asset('frontend/js/bootstrap-fileinput/css/fileinput.min.css') }}" media="all" rel="stylesheet"
          type="text/css"/>

    <link rel="stylesheet" href="{{asset('frontend/css/custom.css')}}">
    <!-- Modernizer js -->
    <script src="{{ asset('frontend/js/vendor/modernizr-3.5.0.min.js') }}"></script>


    @yield('style')
</head>
<body>
<div id="app">
    <!-- Main wrapper -->
    <div class="wrapper" id="wrapper">
        <!-- Header Area -->
    @include('partial.frontend.header')
    <!-- //Header Area -->

        <!-- Start Blog Area -->
        <main>
            <div class="page-blog-details section-padding--lg bg--white">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            @include('partial.flash')
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
        <!-- End Blog Area -->

        <!-- Footer Area -->
    @include('partial.frontend.footer')

    <!-- //Footer Area -->

    </div>
    <!-- //Main wrapper -->

    {{--        <main class="py-4">--}}
    {{--            @yield('content')--}}
    {{--        </main>--}}
</div>


<script src="{{ asset('js/app.js') }}"></script>
<!-- JS Files -->
<script src="{{ asset('frontend/js/plugins.js') }}"></script>
<script src="{{ asset('frontend/js/active.js') }}"></script>

<script src="{{ asset('frontend/js/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>

<script src="{{ asset('frontend/js/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-fileinput/themes/fa/theme.js') }}"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>

@yield('script')
</body>
</html>
