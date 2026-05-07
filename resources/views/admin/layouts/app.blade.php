<!doctype html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/font-awesome/css/font-awesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/elusive-icons/css/elusive-webfont.css') }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/theme-custom.css') }}"/>

    <!-- Head Libs -->
    <script src="{{ asset('assets/admin/vendor/modernizr/modernizr.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')
</head>
<body>
<section class="body">

    @include('admin.layouts.header')

    <div class="inner-wrapper">
        @include('admin.layouts.menu')
        @yield('content')
    </div>

</section>

<!-- Vendor JS -->
<script src="{{ asset('assets/admin/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/popper/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/nanoscroller/nanoscroller.js') }}"></script>

<!-- Theme -->
<script src="{{ asset('assets/admin/js/theme.js') }}"></script>
<script src="{{ asset('assets/admin/js/theme.init.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/jquery-maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.maskMoney.js') }}"></script>
<script src="{{ asset('assets/admin/js/admin.js') }}"></script>

@stack('scripts')

</body>
</html>
