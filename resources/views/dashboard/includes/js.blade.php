@push('scripts')
    {{-- theme --}}
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/tags/tag.js') }}"></script>
    <script src="{{ asset('assets/js/tags/init.js') }}"></script>

    <script src="{{ asset('assets/js/validation.js') }}"></script>

    <script src="{{ asset('assets/js/images.js') }}"></script>

    <script src="{{ asset('assets/js/editors/editor.js') }}"></script>
    <script src="{{ asset('assets/js/editors/init.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush
@stack('scripts')
