@extends('dashboard.index')
@section('title', 'Devis')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Liste des devis
                <a href="{{ route('devis.create') }}" class="float-right btn btn-sm btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="bi bi-plus"></i>
                    </span>
                    <span class="text">Ajouter</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover table-centered dt-responsive nowrap w-100" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Client</th>
                            <th>statut</th>
                            <th>Date emission</th>
                            <th>Date echeance</th>
                            <th>Etat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devis as $devi)
                            <tr>
                                <td>{{ $devi->numero }}</td>
                                <td>{{ $devi->Client->prenom ?? '' }} {{ $devi->Client->nom ?? '' }}</td>
                                <td>
                                    @if ($devi->statut)
                                        <span class="badge badge-success">{{ 'accepté' }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ 'en attente' }}</span>
                                    @endif
                                </td>
                                <td>{{ formatDate($devi->date_emission) }}</td>
                                <td>{{ formatDate($devi->date_echeance) }}</td>
                                <td>
                                    @if ($devi->etat)
                                        <span class="badge badge-success">{{ 'activé' }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ 'déactivé' }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bi bi-ellipsis-h fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            @if ($devi->archive == false)
                                                <a href="{{ route('devis.archive', $devi->id) }}" class="dropdown-item">
                                                    <span class="icon">
                                                        <i class="bi bi-archive"></i>
                                                    </span>
                                                    <span class="text">Archiver</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('devis.show', crypter($devi->id)) }}" target="_blank"
                                                class="dropdown-item">
                                                <span class="icon">
                                                    <i class="bi bi-eye"></i>
                                                </span>
                                                <span class="text">Consulter</span>
                                            </a>
                                            <a href="{{ route('devis.edit', $devi->id) }}" class="dropdown-item">
                                                <span class="icon">
                                                    <i class="bi bi-edit"></i>
                                                </span>
                                                <span class="text">Modifier</span>
                                            </a>
                                            @if ($devi->etat)
                                                <a href="{{ route('devis.etat', $devi->id) }}"
                                                    class="dropdown-item text-danger">
                                                    <span class="icon">
                                                        <i class="bi bi-times"></i>
                                                    </span>
                                                    <span class="text">Désactiver</span>
                                                </a>
                                            @else
                                                <a href="{{ route('devis.etat', $devi->id) }}"
                                                    class="dropdown-item text-success">
                                                    <span class="icon">
                                                        <i class="bi bi-check"></i>
                                                    </span>
                                                    <span class="text">Activer</span>
                                                </a>
                                            @endif
                                            @if ($devi->statut)
                                                <a href="{{ route('devis.statut', $devi->id) }}"
                                                    class="dropdown-item text-danger">
                                                    <span class="icon">
                                                        <i class="bi bi-times"></i>
                                                    </span>
                                                    <span class="text">Refusé</span>
                                                </a>
                                            @else
                                                <a href="{{ route('devis.statut', $devi->id) }}"
                                                    class="dropdown-item text-success">
                                                    <span class="icon">
                                                        <i class="bi bi-check"></i>
                                                    </span>
                                                    <span class="text">Validé</span>
                                                </a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" data-toggle="modal"
                                                data-target="#delete-devi-{{ $devi->id }}">
                                                <span class="icon ">
                                                    <i class="bi bi-trash"></i>
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
    @foreach ($devis as $devi)
        <div class="modal fade" id="delete-devi-{{ $devi->id }}" tabindex="-1"
            aria-labelledby="devi-{{ $devi->id }}Label" aria-hidden="true">
            @component('components.modal-delete', ['action' => route('devis.destroy', $devi->id)])
            @endcomponent
        </div>
    @endforeach
@endsection
