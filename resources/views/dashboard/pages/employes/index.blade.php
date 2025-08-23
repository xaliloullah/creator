@extends('dashboard.index')
@section('title', 'employes')
@section('subtitle', 'Liste')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.css') }}">
    @endpush
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Liste des employes</h1>
            <p class="text-muted mb-0">Retrouvez ci-dessous tous les employes disponibles dans l'application.</p>
        </div>
        <a href="{{ route('employes.create') }}" class="btn btn-outline-dark">
            <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
        </a>
    </div>

    <div class="card border-0 shadow">
        <div class="table-responsive card-body">
            <table class="datatables table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th>Prénom & Nom</th>
                        <th>Email</th>
                        <th>Téléphones</th>
                        <th>Statut</th>
                        <th>Date de création</th>
                        <th class="d-print-none">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employes as $employe)
                        <tr>
                            <td><img src="{{ asset('assets/images/' . $employe->image()) }}" alt="profil"
                                    class="img-xs img-square rounded-circle profil mx-auto me-2" />{{ $employe->prenom }}
                                {{ $employe->nom }}</td>
                            <td>
                                @component('components.tags', ['badge' => $employe->email_statut])
                                @endcomponent
                                {{ $employe->email }}
                            </td>
                            <td><a href="tel:{{ $employe->telephone }}">{{ $employe->telephone }}</a></td>
                            <td>
                                @component('components.tags', ['badge' => $employe->statut])
                                @endcomponent
                            </td>
                            <td>{{ formatDate($employe->created_at) }}</td>
                            <td class="no-select">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('employes.show', $employe->id) }}"><i
                                                    class="bi bi-eye me-2"></i>Consulter</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('employes.edit', $employe->id) }}"><i
                                                    class="bi bi-pencil-square me-2"></i>Modifier</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#delete-employe-{{ $employe->id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete-employe-{{ $employe->id }}"><i
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

    @foreach ($employes as $employe)
        <div class="modal fade" id="delete-employe-{{ $employe->id }}" tabindex="-1"
            aria-labelledby="employe-{{ $employe->id }}-label" aria-hidden="true">
            @component('components.modals.delete', ['action' => route('employes.destroy', $employe->id)])
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
