@extends('dashboard.index')
@section('title', 'qrcodes')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Liste des qrcodes
                <a href="{{ route('qrcodes.create') }}" class="float-right btn btn-sm btn-success btn-icon-split">
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
                            <th>Lien</th>
                            <th>Created at</th>
                            <th>Uprated at</th>
                            <th>statut</th>
                            <th>Etat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($qrcodes as $qrcode)
                            <tr>
                                <td>{{ $qrcode->id }}</td>
                                <td><a class="copy-text" href="{{ route('qrcodes.show', crypter($qrcode->id)) }}"
                                        data-copy="{{ route('qrcodes.show', crypter($qrcode->id)) }}">{{ Str::limit(route('qrcodes.show', crypter($qrcode->id)), 20) }}</a><a class="btn btn-sm btn-outline-dark copy-btn ml-3"><i
                                            class="fa fa-copy"></i></a>
                                </td>
                                <td>{{ formatDateTime($qrcode->created_at) }}</td>
                                <td>{{ formatDateTime($qrcode->updated_at) }}</td>
                                <td>
                                    @if ($qrcode->statut)
                                        <span class="badge badge-success">{{ 'payé' }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ 'trial' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($qrcode->etat)
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
                                            @if ($qrcode->archive == false)
                                                <a href="{{ route('qrcodes.archive', $qrcode->id) }}" class="dropdown-item">
                                                    <span class="icon">
                                                        <i class="fas fa-archive"></i>
                                                    </span>
                                                    <span class="text">Archiver</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('qrcodes.show', crypter($qrcode->id)) }}" class="dropdown-item"
                                                target="_blank">
                                                <span class="icon">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                                <span class="text">Consulter</span>
                                            </a>
                                            <a href="{{ route('qrcodes.edit', $qrcode->id) }}" class="dropdown-item">
                                                <span class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Modifier</span>
                                            </a>
                                            @if ($qrcode->etat)
                                                <a href="{{ route('qrcodes.etat', $qrcode->id) }}"
                                                    class="dropdown-item text-danger">
                                                    <span class="icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="text">Désactiver</span>
                                                </a>
                                            @else
                                                <a href="{{ route('qrcodes.etat', $qrcode->id) }}"
                                                    class="dropdown-item text-success">
                                                    <span class="icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Activer</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('qrcodes.pdf', $qrcode->id) }}" class="dropdown-item">
                                                <span class="icon">
                                                    <i class="fas fa-download"></i>
                                                </span>
                                                <span class="text">Télécharger</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" data-toggle="modal"
                                                data-target="#delete-qrcode-{{ $qrcode->id }}">
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
    @foreach ($qrcodes as $qrcode)
        <div class="modal fade" id="delete-qrcode-{{ $qrcode->id }}" tabindex="-1"
            aria-labelledby="qrcode-{{ $qrcode->id }}Label" aria-hidden="true">
            @component('components.modal-delete', ['action' => route('qrcodes.destroy', $qrcode->id)])
            @endcomponent
        </div>
    @endforeach
    <script>
        document.querySelectorAll(".copy-btn").forEach((button, index) => {
            button.addEventListener("click", () => {
                const textToCopy = document
                    .querySelectorAll(".copy-text")[index].getAttribute("data-copy");
                navigator.clipboard
                    .writeText(textToCopy)
                    .then(() => {
                        button.innerHTML = "copié";
                        setTimeout(() => {
                            button.innerHTML = "<i class='fa fa-copy'></i>";
                        }, 2000);
                    })
                    .catch((err) => {
                        console.error("Erreur lors de la copie", err);
                    });
            });
        });
    </script>
@endsection
