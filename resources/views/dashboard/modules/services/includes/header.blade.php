<!-- Top Navbar -->
<header class="top-navbar d-flex navbar-light bg-white bg-gradient sticky-top align-items-center px-3 shadow">
    <div class="navbar-brand d-flex align-items-center">
        <button class="btn d-md-none me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
            <i class="bi bi-list fs-4"></i>
        </button>
        <a href="#" class="text-decoration-none text-dark">
            <img src="{{ asset('assets/images/' . $service->image()) }}" class="navbar-brand-logo" alt="logo" />
            <span class="navbar-brand-text">{{ $service->designation }}</span>
        </a>
    </div>
    <div class="ms-auto d-flex align-items-center gap-3">
        {{-- <div class="dropdown">
            <button type="button" class="btn" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <div class="position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ count(auth()->user()->unreadNotifications) }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    @endif
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <h6 class="dropdown-header text-center">
                    Notifications
                </h6>
                @foreach (auth()->user()->unreadNotifications->take(4) as $notification)
                    <li>
                        <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('notifications.show', $notification->id) }}">
                            <div class="dropdown-list-image mr-3">
                                <img class="rounded-circle" src="{{ asset('assets/images/logo.png') }}" alt="...">
                                <div class="status-indicator bg-success"></div>
                            </div>
                            <div class="font-weight-bold">
                                <div class="text-truncate text-capitalize">{{ $notification->data['title'] }}</div>
                                <div class="text-truncate small text-gray-700">{{ $notification->data['message'] }}
                                </div>
                                <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach

                <li>
                    <a class="dropdown-item text-center small text-gray-500"
                        href="{{ route('notifications.index') }}">Lire
                        plus de messages</a>
                </li>
            </ul>
        </div> --}}
        <a class="btn" href="#settings" data-bs-toggle="modal" data-bs-target="#settings-modal">
            <i class="bi bi-search fs-5"></i>
        </a>
        {{-- <div class="dropdown">
            <button class="btn d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                <img src="{{ asset('assets/images/' . auth()->user()->image()) }}" alt="User"
                    class="rounded-circle img-xs" />

                <span class="d-none d-md-block">{{ auth()->user()->prenom }}
                    {{ auth()->user()->nom }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                @admin
                    <a class="dropdown-item" href="{{ route('admin') }}" target="_blank">
                        <i class="bi bi-window me-2"></i>
                        Admin
                    </a>
                @endadmin
                <li>
                    <a class="dropdown-item" href="{{ route('dashboard') }}">
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
        </div> --}}
    </div>
</header>
