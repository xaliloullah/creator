<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name') }} @hasSection('title')
            - @yield('title')
        @endif
    </title>
    @push('styles')
        <link href="{{ asset('assets/images/favicon.ico') }}" rel="icon" type="image/png">
        <link href="{{ asset('assets/css/bootstrap/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/bootstrap/icons/font/bootstrap-icons.css') }}" rel="stylesheet">
        {{-- <link href="{{ asset('assets/css/editor.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('assets/css/tags.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/images.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        {{-- <script src="{{ asset('assets/js/translate/init.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/translate/translate.js') }}" type="text/javascript"></script> --}}
    @endpush

    @stack('styles')



</head>
