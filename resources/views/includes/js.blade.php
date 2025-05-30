@push('scripts')
    {{-- theme --}}
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.js') }}"></script>

    <script src="{{ asset('assets/js/validation.js') }}"></script>

    <script src="{{ asset('assets/js/images.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush
@stack('scripts')
