<link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">

<script src="{{ asset('assets/js/sweetalert.js') }}"></script>

{{-- Notification de succès --}}
@if (session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: "{!! session('success') !!}",
            showConfirmButton: false,
            timer: 3000,
        });
    </script>
@endif

{{-- Notification d'erreur(s) --}}
@if ($errors->updatePassword->any())
    <script>
        let errorMessages = @json($errors->updatePassword->all());
        errorMessages.forEach(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: error,
                showConfirmButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                cancelButtonColor: 'var(--bs-danger)',
                background: 'var(--bs-light)',
                color: 'var(--bs-secondary)',
            });
        });
    </script>
@endif

@if ($errors->userDeletion->any())
    <script>
        let errorMessages = @json($errors->userDeletion->all());
        errorMessages.forEach(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: error,
                showConfirmButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                cancelButtonColor: 'var(--bs-danger)',
                background: 'var(--bs-light)',
                color: 'var(--bs-secondary)',
            });
        });
    </script>
@endif
@if ($errors->any())
    <script>
        let errorMessages = @json($errors->all());
        errorMessages.forEach(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: error,
                showConfirmButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                cancelButtonColor: 'var(--bs-danger)',
                background: 'var(--bs-light)',
                color: 'var(--bs-secondary)',
            });
        });
    </script>
@endif

{{-- Notification d'avertissement --}}
@if (session()->has('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Attention',
            text: "{!! session('warning') !!}",
            showConfirmButton: true,
            confirmButtonColor: 'var(--bs-primary)',
            background: 'var(--bs-light)',
            color: 'var(--bs-secondary)',
        });
    </script>
@endif

{{-- Notification d'information --}}
@if (session()->has('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: "{!! session('info') !!}",
            showConfirmButton: true,
            confirmButtonColor: 'var(--bs-primary)',
            background: 'var(--bs-light)',
            color: 'var(--bs-secondary)',
        });
    </script>
@endif

<div class="toast-container position-fixed top-0 end-0 p-3 border-0">
    <div id="invalid-toast" class="toast align-items-center card-ghost" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-file"></i> Il y a des erreurs dans le formulaire. Veuillez les corriger.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>
