@extends('dashboard.index')
@section('title', 'Access')
@section('title2', 'Liste')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.css') }}">
    @endpush
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Liste des access</h1>
            <p class="text-muted mb-0">Retrouvez ci-dessous tous les access disponibles dans l'application.</p>
        </div>
        <a href="{{ route('access.create') }}" class="btn btn-outline-dark">
            <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
        </a>
    </div>

    <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button"
                role="tab" aria-controls="roles" aria-selected="true">Roles</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="permission-tab" data-bs-toggle="tab" data-bs-target="#permission" type="button"
                role="tab" aria-controls="permission" aria-selected="false">Permissions</button>
        </li>
    </ul>
    <div class="tab-content" id="components-content">
        <div class="tab-pane fade show active" id="roles" role="tabpanel" aria-labelledby="roles-tab" tabindex="0">
            @include('admin.modules.access.roles.index')
        </div>
        <div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tab" tabindex="0">
            @include('admin.modules.access.permissions.index')
        </div>
    </div>

    @foreach ($roles as $role)
        <div class="modal fade" id="delete-role-{{ $role->id }}" tabindex="-1"
            aria-labelledby="role-{{ $role->id }}-label" aria-hidden="true">
            @component('components.modals.delete', ['action' => route('roles.delete', $role->id)])
            @endcomponent
        </div>
    @endforeach
    @foreach ($permissions as $permission)
        <div class="modal fade" id="delete-permission-{{ $permission->id }}" tabindex="-1"
            aria-labelledby="permission-{{ $permission->id }}-label" aria-hidden="true">
            @component('components.modals.delete', ['action' => route('permissions.delete', $permission->id)])
            @endcomponent
        </div>
    @endforeach

    @push('scripts')
        <script src="{{ asset('assets/js/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/jquery.datatables.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/responsive.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/responsive.bootstrap.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/buttons.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/jszip.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/pdfmake.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/buttons.html5.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/buttons.print.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/buttons.colvis.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/select.js') }}"></script>

        <script src="{{ asset('assets/js/datatables/init.js') }}"></script>
    @endpush
@endsection
