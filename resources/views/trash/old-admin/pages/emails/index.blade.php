@extends('dashboard.index')
@section('title', 'emails')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Liste des emails
                <a href="{{ route('emails.create') }}" class="float-right btn btn-sm btn-success btn-icon-split">
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
                            <th>Subject</th>
                            <th>Created at</th>
                            <th>Uprated at</th>
                            <th>statut</th>
                            <th>Etat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emails as $email)
                            <tr>
                                <td>{{ $email->subject }}</td>

                                <td>{{ formatDateTime($email->created_at) }}</td>
                                <td>{{ formatDateTime($email->updated_at) }}</td>
                                <td>
                                    @if ($email->statut)
                                        <span class="badge badge-success">{{ 'payé' }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ 'trial' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($email->etat)
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
                                            @if ($email->archive == false)
                                                <a href="{{ route('emails.archive', $email->id) }}" class="dropdown-item">
                                                    <span class="icon">
                                                        <i class="fas fa-archive"></i>
                                                    </span>
                                                    <span class="text">Archiver</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('emails.show', crypter($email->id)) }}" class="dropdown-item"
                                                target="_blank">
                                                <span class="icon">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                                <span class="text">Consulter</span>
                                            </a>
                                            <a href="{{ route('emails.edit', $email->id) }}" class="dropdown-item">
                                                <span class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Modifier</span>
                                            </a>
                                            @if ($email->etat)
                                                <a href="{{ route('emails.etat', $email->id) }}"
                                                    class="dropdown-item text-danger">
                                                    <span class="icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="text">Désactiver</span>
                                                </a>
                                            @else
                                                <a href="{{ route('emails.etat', $email->id) }}"
                                                    class="dropdown-item text-success">
                                                    <span class="icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Activer</span>
                                                </a>
                                            @endif
                                            {{-- @if ($email->statut)
                                                <a href="{{ route('emails.statut', $email->id) }}"
                                                    class="dropdown-item text-danger">
                                                    <span class="icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="text">Annuler</span>
                                                </a>
                                            @else
                                                <a href="{{ route('emails.statut', $email->id) }}"
                                                    class="dropdown-item text-success">
                                                    <span class="icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Payer</span>
                                                </a>
                                            @endif --}}
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" data-toggle="modal"
                                                data-target="#delete-email-{{ $email->id }}">
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
    @foreach ($emails as $email)
        <div class="modal fade" id="delete-email-{{ $email->id }}" tabindex="-1"
            aria-labelledby="email-{{ $email->id }}Label" aria-hidden="true">
            @component('components.modal-delete', ['action' => route('emails.destroy', $email->id)])
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
