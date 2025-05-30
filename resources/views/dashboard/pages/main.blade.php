@extends('dashboard.index')
{{-- @section('title', 'Dashboard') --}}
@section('content')
    {{-- <div class="card shadow">
        <div class="card-header">
            Abonnement
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover table-centered dt-responsive nowrap w-100" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Date debut</th>
                            <th>Date fin</th>
                            <th>Statut</th>
                            <th>Etat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($abonnements = auth()->user()->Abonnements ?? [] as $abonnement)
                            <tr>
                                <td>{{ $abonnement->id }}</td>
                                <td>{{ formatDateTime($abonnement->date_debut) }}</td>
                                <td>{{ formatDateTime($abonnement->date_fin) }}</td>
                                <td>
                                    @if ($abonnement->getStatut() == 'actif')
                                        @php
                                            $badge = 'success';
                                        @endphp
                                    @elseif ($abonnement->getStatut() == 'expiré')
                                        @php
                                            $badge = 'warning';
                                        @endphp
                                    @else
                                        @php
                                            $badge = 'info';
                                        @endphp
                                    @endif
                                    <span class="badge badge-{{ $badge }}">{{ $abonnement->getStatut() }}</span>
                                </td>
                                <td>
                                    @if ($abonnement->etat)
                                        <span class="badge badge-success">{{ 'activé' }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ 'déactivé' }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            @if ($abonnement->archive == false)
                                                <a href="{{ route('abonnements.archive', crypter($abonnement->id)) }}"
                                                    class="dropdown-item">
                                                    <span class="icon">
                                                        <i class="fas fa-archive"></i>
                                                    </span>
                                                    <span class="text">Archiver</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('abonnements.show', crypter($abonnement->id)) }}"
                                                class="dropdown-item" target="_blank">
                                                <span class="icon">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                                <span class="text">Consulter</span>
                                            </a>
                                            <a href="{{ route('abonnements.edit', $abonnement->id) }}"
                                                class="dropdown-item">
                                                <span class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Modifier</span>
                                            </a>
                                            @if ($abonnement->etat)
                                                <a href="{{ route('abonnements.etat', $abonnement->id) }}"
                                                    class="dropdown-item text-danger">
                                                    <span class="icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="text">Désactiver</span>
                                                </a>
                                            @else
                                                <a href="{{ route('abonnements.etat', $abonnement->id) }}"
                                                    class="dropdown-item text-success">
                                                    <span class="icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Activer</span>
                                                </a>
                                            @endif
                                            {{-- @if ($abonnement->statut)
                                                    <a href="{{ route('abonnements.statut', $abonnement->id) }}"
                                                        class="dropdown-item text-danger">
                                                        <span class="icon">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                        <span class="text">Annuler</span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('abonnements.statut', $abonnement->id) }}"
                                                        class="dropdown-item text-success">
                                                        <span class="icon">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                        <span class="text">Payer</span>
                                                    </a>
                                                @endif
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" data-toggle="modal"
                                                data-target="#delete-abonnement-{{ $abonnement->id }}">
                                                <span class="icon ">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Supprimer</span>
                                            </a>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach ($abonnements as $abonnement)
        <div class="modal fade" id="delete-abonnement-{{ $abonnement->id }}" tabindex="-1"
            aria-labelledby="abonnement-{{ $abonnement->id }}Label" aria-hidden="true">
            @component('components.modal-delete', ['action' => route('abonnements.destroy', $abonnement->id)])
            @endcomponent
        </div>
    @endforeach
    <div class="row">

    </div> --}}
    <!-- Main Content -->
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3">Dashboard Overview</h1>
        </div>
    </div>
    {{-- <form action="{{ route('switch-database') }}" method="POST">
        @csrf
        <label for="database_name">Choisir une base de données:</label>
        <select name="database_name" id="database_name">
            <option value="database_1">Base de données 1</option>
            <option value="database_2">Base de données 2</option>
            <option value="database_3">Base de données 3</option>
            <!-- Ajoute ici toutes les bases de données possibles -->
        </select>
        <button type="submit">Changer</button>
    </form> --}}

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">
                                Total Sales
                            </h6>
                            <h3 class="mb-0">$24,500</h3>
                        </div>
                        <div class="text-primary">
                            <i class="bi bi-currency-dollar fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">
                                Active Users
                            </h6>
                            <h3 class="mb-0">1,250</h3>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">
                                New Orders
                            </h6>
                            <h3 class="mb-0">342</h3>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-cart fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">
                                Growth
                            </h6>
                            <h3 class="mb-0">+24.5%</h3>
                        </div>
                        <div class="text-info">
                            <i class="bi bi-graph-up fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Abonnement & Tasks -->
    <div class="row g-4">
        <!-- Abonnement -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        Mes Abonnements
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Date debut</th>
                                    <th>Date fin</th>
                                    <th>Statut</th>
                                    <th>Etat</th>
                                    <th class="d-print-none">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($abonnements = auth()->user()->Abonnements ?? [] as $abonnement)
                                    <tr>
                                        <td>{{ $abonnement->id }}</td>
                                        <td>{{ formatDateTime($abonnement->date_debut) }}</td>
                                        <td>{{ formatDateTime($abonnement->date_fin) }}</td>
                                        <td>
                                            @if ($abonnement->getStatut() == 'actif')
                                                @php
                                                    $badge = 'success';
                                                @endphp
                                            @elseif ($abonnement->getStatut() == 'expiré')
                                                @php
                                                    $badge = 'warning';
                                                @endphp
                                            @else
                                                @php
                                                    $badge = 'info';
                                                @endphp
                                            @endif
                                            <span
                                                class="badge badge-{{ $badge }}">{{ $abonnement->getStatut() }}</span>
                                        </td>
                                        <td>
                                            @if ($abonnement->etat)
                                                <span class="badge badge-success">{{ 'activé' }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ 'déactivé' }}</span>
                                            @endif
                                        </td>
                                        <td class="no-select">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-icon"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('abonnements.show', crypter($abonnement->id)) }}"><i
                                                                class="bi bi-eye me-2"></i>Consulter</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('abonnements.edit', $abonnement->id) }}"><i
                                                                class="bi bi-pencil-square me-2"></i>Modifier</a>
                                                    </li>
                                                    <li>
                                                        @if ($abonnement->etat)
                                                            <a href="{{ route('abonnements.etat', $abonnement->id) }}"
                                                                class="dropdown-item text-danger">
                                                                <i class="bi bi-x me-2"></i>Désactiver</a>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('abonnements.etat', $abonnement->id) }}"
                                                                class="dropdown-item text-success">
                                                                <i class="bi bi-check me-2"></i>Activer
                                                            </a>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#logout"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete-abonnement-{{ $abonnement->id }}"><i
                                                                class="bi bi-trash me-2"></i>Supprimer</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                        {{-- <td class="text-center">
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button"
                                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    @if ($abonnement->archive == false)
                                                        <a href="{{ route('abonnements.archive', crypter($abonnement->id)) }}"
                                                            class="dropdown-item">
                                                            <span class="icon">
                                                                <i class="fas fa-archive"></i>
                                                            </span>
                                                            <span class="text">Archiver</span>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('abonnements.show', crypter($abonnement->id)) }}"
                                                        class="dropdown-item" target="_blank">
                                                        <span class="icon">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                        <span class="text">Consulter</span>
                                                    </a>
                                                    <a href="{{ route('abonnements.edit', $abonnement->id) }}"
                                                        class="dropdown-item">
                                                        <span class="icon">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Modifier</span>
                                                    </a>
                                                    @if ($abonnement->etat)
                                                        <a href="{{ route('abonnements.etat', $abonnement->id) }}"
                                                            class="dropdown-item text-danger">
                                                            <span class="icon">
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                            <span class="text">Désactiver</span>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('abonnements.etat', $abonnement->id) }}"
                                                            class="dropdown-item text-success">
                                                            <span class="icon">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Activer</span>
                                                        </a>
                                                    @endif

                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item text-danger" data-toggle="modal"
                                                        data-target="#delete-abonnement-{{ $abonnement->id }}">
                                                        <span class="icon ">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                        <span class="text">Supprimer</span>
                                                    </a>
                                                </div>
                                            </div>

                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Tasks</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="task1" />
                                <label class="form-check-label" for="task1">
                                    Review new orders
                                </label>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="task2" />
                                <label class="form-check-label" for="task2">
                                    Update inventory
                                </label>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="task3" />
                                <label class="form-check-label" for="task3">
                                    Respond to support tickets
                                </label>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="task4" />
                                <label class="form-check-label" for="task4">
                                    Prepare monthly report
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
