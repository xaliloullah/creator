<link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">

<script src="{{ asset('assets/js/sweetalert.js') }}"></script>

{{-- Notification de succès --}}
@if (session()->has('success'))
    <script>
        Swal.fire({
            toast: true,
            icon: 'success',
            title: "{!! session('success') !!}",
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: 'var(--bs-success)',
            color: 'var(--bs-white-text-emphasis)',
        });
    </script>
@endif

{{-- Notification d'erreur(s) --}}
@if ($errors->updatePassword->any())
    <script>
        let errorMessages = @json($errors->updatePassword->all());
        errorMessages.forEach(error => {
            Swal.fire({
                toast: true,
                icon: 'error',
                title: error,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: 'var(--bs-danger)',
                color: 'var(--bs-white-text-emphasis)',
            });
        });
    </script>
@endif

@if ($errors->userDeletion->any())
    <script>
        let errorMessages = @json($errors->userDeletion->all());
        errorMessages.forEach(error => {
            Swal.fire({
                toast: true,
                icon: 'error',
                title: error,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: 'var(--bs-danger)',
                color: 'var(--bs-white-text-emphasis)',
            });
        });
    </script>
@endif

@if ($errors->any())
    <script>
        let errorMessages = @json($errors->all());
        errorMessages.forEach(error => {
            Swal.fire({
                toast: true,
                icon: 'error',
                title: error,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: 'var(--bs-danger)',
                color: 'var(--bs-white-text-emphasis)',
            });
        });
    </script>
@endif

{{-- Notification d'avertissement --}}
@if (session()->has('warning'))
    <script>
        Swal.fire({
            toast: true,
            icon: 'warning',
            title: "{!! session('warning') !!}",
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: 'var(--bs-warning)',
            color: 'var(--bs-white-text-emphasis)',
        });
    </script>
@endif

{{-- Notification d'information --}}
@if (session()->has('info'))
    <script>
        Swal.fire({
            toast: true,
            icon: 'info',
            title: "{!! session('info') !!}",
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: 'var(--bs-info)',
            color: 'var(--bs-white-text-emphasis)',
        });
    </script>
@endif


<div class="toast-container position-fixed top-0 end-0 p-3 border-0">
    <div id="invalid-toast" class="toast align-items-center card-ghost text-danger" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle"></i> Il y a des erreurs dans le formulaire. Veuillez les corriger.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>




{{--  
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
     
    @if (session()->has('success'))
        <div class="toast align-items-center card-ghost border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {!! session('success') !!}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
            </div>
        </div>
    @endif
 
    @if ($errors->updatePassword->any())
        @foreach ($errors->updatePassword->all() as $error)
            <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
            </div>
        @endforeach
    @endif
 
    @if ($errors->userDeletion->any())
        @foreach ($errors->userDeletion->all() as $error)
            <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
            </div>
        @endforeach
    @endif
 
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
            </div>
        @endforeach
    @endif
 
    @if (session()->has('warning'))
        <div class="toast align-items-center text-bg-warning border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {!! session('warning') !!}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
            </div>
        </div>
    @endif
 
    @if (session()->has('info'))
        <div class="toast align-items-center text-bg-info border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {!! session('info') !!}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
            </div>
        </div>
    @endif
</div>
 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let toastElList = [].slice.call(document.querySelectorAll('.toast'))
        let toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 4000, autohide: true })
        });
        toastList.forEach(toast => toast.show());
    });
</script>
--}}
