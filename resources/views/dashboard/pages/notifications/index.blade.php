@extends('dashboard.index')
@section('title', 'Notifications')
@section('content')
    <main class="col py-3 main-content">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3">Notifications</h1>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th width='50%'>Message</th>
                                        <th>Envoyée</th>
                                        <th>statut</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{ $notification->data['title'] }}</td>
                                            <td>{{ Str::limit($notification->data['message'], 30, '...') }}</td>
                                            <td><small> {{ $notification->created_at->diffForHumans() }} </small></td>
                                            <td>
                                                @if ($notification->read_at)
                                                    <span class="badge badge-success">{{ 'lue' }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ 'non lue' }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown no-arrow">
                                                    <a class="dropdown-toggle" href="#" role="button"
                                                        id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h fa-sm fa-fw text-gray-400"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                        aria-labelledby="dropdownMenuLink">
                                                        @if ($notification->archive == false)
                                                            <a href="{{ route('notifications.archive', $notification->id) }}"
                                                                class="dropdown-item">
                                                                <span class="icon">
                                                                    <i class="fas fa-archive"></i>
                                                                </span>
                                                                <span class="text">Archiver</span>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('notifications.show', $notification->id) }}"
                                                            class="dropdown-item">
                                                            <span class="icon">
                                                                <i class="fas fa-eye"></i>
                                                            </span>
                                                            <span class="text">Consulter</span>
                                                        </a>
                                                        @if ($notification->read_at)
                                                            <a href="{{ route('notifications.statut', $notification->id) }}"
                                                                class="dropdown-item text-danger">
                                                                <span class="icon">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                                <span class="text">marquer comme non lue</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('notifications.statut', $notification->id) }}"
                                                                class="dropdown-item text-success">
                                                                <span class="icon">
                                                                    <i class="fas fa-check"></i>
                                                                </span>
                                                                <span class="text">marquer comme lue</span>
                                                            </a>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item text-danger"
                                                            data-toggle="modal"
                                                            data-target="#delete-notification-{{ $notification->id }}">
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
            </div>
        </div>
    </main>
    @foreach ($notifications as $notification)
        <div class="modal fade" id="delete-notification-{{ $notification->id }}" tabindex="-1"
            aria-labelledby="notification-{{ $notification->id }}Label" aria-hidden="true">
            @component('components.modal-delete', ['action' => route('notifications.destroy', $notification->id)])
            @endcomponent
        </div>
    @endforeach
@endsection
