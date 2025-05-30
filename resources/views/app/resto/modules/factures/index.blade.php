@extends('dashboard.index')
@section('title', 'Factures')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Liste des factures
                <a href="{{ route('factures.create') }}" class="float-right btn btn-sm btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
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
                            <th>Titre</th>
                            <th>Client</th>
                            <th>statut</th>
                            <th>Date emission</th>
                            <th>Date echeance</th>
                            <th>Etat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($factures as $facture)
                            <tr>
                                <td>{{ $facture->numero }}</td>
                                <td>{{ $facture->titre }}</td>
                                <td>{{ $facture->Client->prenom ?? '' }} {{ $facture->Client->nom ?? '' }}</td>
                                <td>
                                    @if ($facture->statut)
                                        <span class="badge badge-success">{{ 'payé' }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ 'impayé' }}</span>
                                    @endif
                                </td>
                                <td>{{ formatDate($facture->date_emission) }}</td>
                                <td>{{ formatDate($facture->date_echeance) }}</td>
                                <td>
                                    @if ($facture->etat)
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
                                            @if ($facture->archive == false)
                                                <a href="{{ route('factures.archive', $facture->id) }}" class="dropdown-item">
                                                    <span class="icon">
                                                        <i class="fas fa-archive"></i>
                                                    </span>
                                                    <span class="text">Archiver</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('factures.show', crypter($facture->id)) }}" target="_blank"
                                                class="dropdown-item">
                                                <span class="icon">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                                <span class="text">Consulter</span>
                                            </a>
                                            <a href="{{ route('factures.edit', $facture->id) }}" class="dropdown-item">
                                                <span class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Modifier</span>
                                            </a>
                                            @if ($facture->etat)
                                                <a href="{{ route('factures.etat', $facture->id) }}"
                                                    class="dropdown-item text-danger">
                                                    <span class="icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="text">Désactiver</span>
                                                </a>
                                            @else
                                                <a href="{{ route('factures.etat', $facture->id) }}"
                                                    class="dropdown-item text-success">
                                                    <span class="icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Activer</span>
                                                </a>
                                            @endif
                                            @if ($facture->statut)
                                                <a href="{{ route('factures.statut', $facture->id) }}"
                                                    class="dropdown-item text-danger">
                                                    <span class="icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="text">Annuler</span>
                                                </a>
                                            @else
                                                <a href="{{ route('factures.statut', $facture->id) }}"
                                                    class="dropdown-item text-success">
                                                    <span class="icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Payer</span>
                                                </a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" data-toggle="modal"
                                                data-target="#delete-facture-{{ $facture->id }}">
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
    @foreach ($factures as $facture)
        <div class="modal fade" id="delete-facture-{{ $facture->id }}" tabindex="-1"
            aria-labelledby="facture-{{ $facture->id }}Label" aria-hidden="true">
            @component('components.modal-delete', ['action' => route('factures.destroy', $facture->id)])
            @endcomponent
        </div>
    @endforeach
@endsection
