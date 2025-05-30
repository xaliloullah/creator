<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Creator - @yield('title')</title>
    @push('styles')
        <link href="{{ asset('assets/images/favicon.ico') }}" rel="icon" type="image/png">
        <link href="{{ asset('assets/css/bootstrap/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/bootstrap/icons/font/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/images.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    @endpush
    @stack('styles')
</head>
{{--
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Creators - @yield('title')</title>
    @push('styles')
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
        <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles -->
        <link href="{{ asset('assets/css/chatbot.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/images.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
    @endpush
    @stack('styles')
</head> --}}
