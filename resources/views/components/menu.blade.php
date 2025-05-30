@if ($module->isVisible())
    <a href="{{ $module->route ? route($module->route) : $module->link }}"
        @if ($module->target) target="{{ $module->target }}" @endif
        @if ($module->submodules) data-bs-toggle="collapse" @endif
        class="nav-link menu px-3 py-2 d-flex align-items-center justify-content-between @if ($module->isLocked()) disabled @endif">
        <span class="d-flex align-items-center">
            <i class="bi {{ $module->icon }} me-2"></i>
            <span class="menu-title">{{ $module->name }}</span>
        </span>

        <span class="mx-auto">
            @if ($module->statut)
                @include('components.tags', ['badge' => $module->statut])
            @endif
        </span>
        @if ($module->isLocked())
            <i class="bi bi-lock-fill"></i>
        @endif

    </a>
@endif
@if ($module->submodules)
    <ul class="collapse submenu list-unstyled" id="{{ $module->value }}">
        @foreach ($module->submodules as $submodule)
            <li class="w-100">
                @include('components.menu', ['module' => $submodule])
            </li>
        @endforeach
    </ul>
@endif
