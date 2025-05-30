<!DOCTYPE html>
<html lang="en">
@include('includes.head')

<body class="bg-light bg-gradient">
    <div class="container">
        @component('components.alert')
        @endcomponent
        <div class="row min-vh-100 align-items-center justify-content-center">
            @yield('content')
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/password.js') }}"></script>
    @endpush
    @include('includes.js')
</body>

</html>
