<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.head')

<body>
    @include('includes.header')
    @yield('content')
    @include('includes.footer')
    @include('includes.js')
    {{-- @livewireScripts --}}
</body>

</html>
