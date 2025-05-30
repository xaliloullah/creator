<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-white bg-gradient shadow-sm mb-3 rounded sticky">
    <div class="container-fluid px-4 py-3 d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0 text-uppercase">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">Dashboard</a>
            </li>
            @if (View::hasSection('title2'))
                <li class="breadcrumb-item">
                    <a href="{{ url()->previous() }}" class="text-decoration-none text-dark">@yield('title')</a>
                </li>
                @if (View::hasSection('title3'))
                    <li class="breadcrumb-item">
                        <a href="{{ url()->previous() }}" class="text-decoration-none text-dark">@yield('title2')</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title3')</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">@yield('title2')</li>
                @endif
            @else
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            @endif
        </ol>

        <!-- Bouton Retour aligné à droite -->
        <a href="{{ url()->previous() }}" class="btn d-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i>Retour
        </a>
    </div>
</nav>
