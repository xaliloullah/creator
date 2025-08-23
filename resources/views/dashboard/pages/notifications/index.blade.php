@extends('dashboard.index')
@section('title', 'Notifications')
@section('subtitle', 'Mes notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Mes notifications</h1>
        <p class="text-muted mb-0">Retrouvez toutes vos notifications récentes.</p>
    </div>
    <a href="#" class="btn btn-outline-dark">
        <i class="bi bi-bell me-1"></i> Marquer tout comme lu
    </a>
</div>

<div class="list-group shadow-sm">
    @php
        $icons = [
            'success' => ['bg' => 'bg-success', 'text' => 'text-success', 'icon' => 'bi-check-circle-fill'],
            'warning' => ['bg' => 'bg-warning', 'text' => 'text-warning', 'icon' => 'bi-exclamation-triangle-fill'],
            'error' => ['bg' => 'bg-danger', 'text' => 'text-danger', 'icon' => 'bi-x-circle-fill'],
            'info' => ['bg' => 'bg-info', 'text' => 'text-info', 'icon' => 'bi-info-circle-fill'],
            'default' => ['bg' => 'bg-secondary', 'text' => 'text-secondary', 'icon' => 'bi-bell-fill'],
        ];
    @endphp

    @forelse ($notifications as $notification)
        @php
            $type = $notification->data['type'] ?? 'default';
            $icon = $icons[$type] ?? $icons['default'];
        @endphp

        <a href="{{ route('notifications.show', $notification->id) }}"
           class="list-group-item list-group-item-action d-flex align-items-start gap-3 py-3 mb-3
           @if(is_null($notification->read_at)) list-group-item-info @endif"
           style="border-radius: 0.5rem; transition: background 0.2s;">
           
            <div class="flex-shrink-0">
                <div class="{{ $icon['bg'] }} bg-opacity-10 {{ $icon['text'] }} rounded-circle d-flex align-items-center justify-content-center"
                     style="width: 48px; height: 48px;">
                    <i class="bi {{ $icon['icon'] }} fs-5"></i>
                </div>
            </div>

            <div class="flex-fill">
                <div class="fw-bold">{{ $notification->data['title'] ?? 'Notification' }}</div>
                <div class="text-muted small">{{ Str::limit($notification->data['message'] ?? '', 100) }}</div>
            </div>

            <div class="text-end text-muted small flex-shrink-0">
                {{ $notification->created_at->diffForHumans() }}
            </div>
        </a>
    @empty
        <div class="list-group-item text-center text-muted py-4">
            Aucune notification pour le moment.
        </div>
    @endforelse
</div>

<div class="mt-3 text-center">
    <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">
        Voir toutes les notifications
    </a>
</div>
@endsection
