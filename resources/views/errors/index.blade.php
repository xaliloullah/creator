<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.head')

<body class="bg-light bg-gradient">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            @yield('content')
        </div>
    </div>
    @include('includes.js')
</body>

</html>
