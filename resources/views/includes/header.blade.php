<!-- Top Navbar -->
<header class="top-navbar d-flex navbar-light bg-white bg-gradient sticky-top align-items-center px-3 shadow">
    <div class="navbar-brand d-flex align-items-center">
        <button class="btn d-md-none me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
        <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
            <img src="{{ asset('assets/images/logo.png') }}" class="navbar-brand-logo" alt="logo" />
            <span class="navbar-brand-text notranslate">{{ config('app.name') }}</span>
        </a>
    </div>
    <div class="ms-auto d-flex align-items-center gap-3">
        @auth
            <div class="dropdown">
                <button type="button" class="btn" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <div class="position-relative">
                        <i class="bi bi-bell fs-5"></i>
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-9">
                                {{ count(auth()->user()->unreadNotifications) }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end scrollbar scrollbar-md shadow p-0" style="width: 350px;">
                    <li
                        class="dropdown-header bg-light sticky-top text-center py-2 border-bottom border-light shadow fw-semibold">
                        <h6 class="mb-0">Notifications</h6>
                    </li>
                    @php
                        $icons = [
                            'success' => [
                                'bg' => 'bg-success',
                                'text' => 'text-success',
                                'icon' => 'bi-check-circle-fill',
                            ],
                            'warning' => [
                                'bg' => 'bg-warning',
                                'text' => 'text-warning',
                                'icon' => 'bi-exclamation-triangle-fill',
                            ],
                            'error' => ['bg' => 'bg-danger', 'text' => 'text-danger', 'icon' => 'bi-x-circle-fill'],
                            'info' => ['bg' => 'bg-info', 'text' => 'text-info', 'icon' => 'bi-info-circle-fill'],
                            'default' => ['bg' => 'bg-secondary', 'text' => 'text-secondary', 'icon' => 'bi-bell-fill'],
                        ];
                    @endphp
                    <div class="p-2">


                        @forelse (auth()->user()->unreadNotifications as $notification)
                            @php
                                $type = $notification->data['type'] ?? 'default';
                                $icon = $icons[$type] ?? $icons['default'];
                            @endphp

                            <li>
                                <a class="dropdown-item d-flex align-items-center border-bottom border-light shadow-sm small py-2 mb-2"
                                    href="{{ route('notifications.show', $notification->id) }}">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="{{ $icon['bg'] }} bg-opacity-10 {{ $icon['text'] }} rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 42px; height: 42px;">
                                            <i class="bi {{ $icon['icon'] }} fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-fill text-truncate" style="min-width: 0;">
                                        <div class="fw-bold text-truncate">{{ $notification->data['title'] }}</div>
                                        <div class="small text-muted text-truncate">{{ $notification->data['message'] }}
                                        </div>
                                        <div class="small text-end text-muted mt-1 fs-9">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="text-center py-3 text-muted">
                                Aucune notification
                            </li>
                        @endforelse
                    </div>
                    <li class="dropdown-footer sticky-bottom bg-light text-center border-top border-light shadow">
                        <a href="{{ route('notifications.index') }}" class="text-decoration-none small d-block py-2">
                            Voir toutes les notifications
                        </a>
                    </li>
                </ul>
            </div>
        @endauth
        <a class="btn" href="#settings" data-bs-toggle="modal" data-bs-target="#settings-modal">
            <i class="bi bi-gear fs-5"></i>
        </a>
        @auth
            <div class="dropdown">
                <button class="btn d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <!-- Image fixe -->
                    <img src="{{ asset('assets/images/' . auth()->user()->image()) }}" alt="User"
                        class="rounded-circle img-xs" />

                    <!-- Nom + badge dans une colonne verticale -->
                    <div class="d-flex flex-column">
                        <span class="d-none d-md-block">
                            {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                        </span>

                        @admin
                            <span class="d-none d-md-block badge bg-success mt-1 fs-9">admin</span>
                        @endadmin
                    </div>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow">
                    {{-- @admin
                    <a class="dropdown-item text-info" href="{{ route('admin') }}" target="_blank">
                        <i class="bi bi-window me-2"></i>
                        Admin
                    </a>
                @endadmin --}}
                    <li>
                        <a class="dropdown-item text-info" href="{{ route('dashboard') }}">
                            <i class="bi bi-window-sidebar me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                class="bi bi-person me-2"></i>Profile</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#settings" data-bs-toggle="modal" data-bs-target="#settings-modal"><i
                                class="bi bi-gear me-2"></i>Paramètres</a>
                    </li>
                    <li>
                        <a id="theme-toggle" href="#theme" class="dropdown-item">
                            <i id="theme-icon" class="bi bi-moon me-2"></i>
                            <span id="theme-text">Mode Sombre</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="#logout" data-bs-toggle="modal"
                            data-bs-target="#logout-modal"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</header>
