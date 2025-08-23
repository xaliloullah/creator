@extends('dashboard.index')
@section('title', 'Notifications')
@section('subtitle', 'Détails')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ $notification->data['title'] ?? 'Notification' }}</h1>
        <a href="{{ route('notifications.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-list-ul"></i> <span class="d-none d-sm-inline ms-2">Retour</span>
        </a>
    </div>

    @php
        $types = [
            'success' => ['bg' => 'bg-success', 'text' => 'text-success', 'icon' => 'bi-check-circle-fill'],
            'warning' => ['bg' => 'bg-warning', 'text' => 'text-warning', 'icon' => 'bi-exclamation-triangle-fill'],
            'error' => ['bg' => 'bg-danger', 'text' => 'text-danger', 'icon' => 'bi-x-circle-fill'],
            'info' => ['bg' => 'bg-info', 'text' => 'text-info', 'icon' => 'bi-info-circle-fill'],
            'default' => ['bg' => 'bg-secondary', 'text' => 'text-secondary', 'icon' => 'bi-bell-fill'],
        ];
        $type = $notification->data['type'] ?? 'default';
        $style = $types[$type] ?? $types['default'];
    @endphp

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header d-flex align-items-center gap-3 {{ $style['bg'] }} bg-opacity-10 {{ $style['text'] }}"
            style="border-radius: 0.5rem 0.5rem 0 0;">
            <i class="bi {{ $style['icon'] }} fs-4"></i>
            <span class="fw-bold">{{ $notification->data['title'] ?? 'Notification' }}</span>
            <small class="text-muted ms-auto">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
        </div>
        <div class="card-body p-4"> 
            <div class="text-muted mb-3">{!! $notification->data['message'] ?? 'Aucun contenu' !!}</div>
            @if (is_null($notification->read_at))
                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i> Marquer comme lue
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
