@extends('dashboard.index')
@section('title', 'Modules')
@section('title2', 'Liste')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.css') }}">
    @endpush
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Liste des modules</h1>
            <p class="text-muted mb-0">Retrouvez ci-dessous tous les modules disponibles dans l'application.</p>
        </div>
        <a href="{{ route('modules.create') }}" class="btn btn-outline-dark">
            <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
        </a>
    </div>

    <div class="card border-0 shadow">
        <div class="table-responsive card-body">
            <table class="datatables table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th>Designation</th>
                        <th>Nom</th>
                        <th>Couleur</th>
                        <th>Icon</th>
                        {{-- <th>Statut</th> --}}
                        <th>Date de création</th>
                        <th class="d-print-none">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modules as $module)
                        <tr>
                            <td>{{ $module->designation }}</td>
                            <td>{{ $module->name }}</td>
                            <td><span class="badge bg-{{ $module->color }}">{{ $module->color }}</span></td>
                            <td><i class="{{ $module->icon }}"></i></td>
                            {{-- <td>
                                @component('components.tags', ['badge' => $module->statut])
                                @endcomponent
                            </td> --}}
                            <td>{{ $module->created_at }}</td>
                            <td class="no-select">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('modules.show', $module->id) }}"><i
                                                    class="bi bi-eye me-2"></i>Consulter</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('modules.edit', $module->id) }}"><i
                                                    class="bi bi-pencil-square me-2"></i>Modifier</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#delete-module-{{ $module->id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete-module-{{ $module->id }}"><i
                                                    class="bi bi-trash me-2"></i>Supprimer</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($modules as $module)
        <div class="modal fade" id="delete-module-{{ $module->id }}" tabindex="-1"
            aria-labelledby="module-{{ $module->id }}-label" aria-hidden="true">
            @component('components.modals.delete', ['action' => route('modules.destroy', $module->id)])
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
