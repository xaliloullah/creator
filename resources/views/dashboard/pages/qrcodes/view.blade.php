<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.head')

<body class="bg-light bg-gradient">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="rounded-5 bg-gradient shadow-lg overflow-hidden">
            {!! $result !!}
        </div>
    </div>
    @include('includes.js')
</body>

</html>
