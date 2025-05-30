@extends('dashboard.index')
@section('title', 'Notifications')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-print-none">
            <h5 class="m-0 font-weight-bold text-dark">
                {{$notification->data['title'] ?? 'Notification'}}
                <a href="{{ route('notifications.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split ml-3">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h5>
        </div>

        <div class="card-body">
            <p>{{ $notification->data['message'] ?? 'Aucun contenu disponible pour cette notification.' }}</p>
            <hr>
            <small class="text-muted">Envoyée : {{ $notification->created_at->diffForHumans() }}</small>
            <br>
            @if($notification->read_at)
                <small class="text-muted">Lue : {{ $notification->read_at->diffForHumans() }}</small>
            @else
                <small class="text-warning">Non lue</small>
            @endif
        </div>
    </div>
@endsection
