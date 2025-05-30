<!-- Sidebar -->
<div class="sidebar scrollbar collapse d-md-block shadow bg-light bg-gradient" id="sidebar">
    <div class="d-flex flex-column min-vh-100">
        <ul class="nav flex-column mb-sm-auto mb-0 align-items-start w-100" id="menu">

            {{-- <li class="nav-item w-100">
                <a href="{{ route('dashboard') }}" class="nav-link menu px-3 py-2">
                    <i class="bi bi-speedometer2 me-2"></i>
                    <span class="menu-title">DASHBOARD</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="#app" data-bs-toggle="collapse" class="nav-link menu px-3 py-2">
                    <i class="bi bi-grid me-2"></i>
                    <span class="menu-title">APP</span>
                </a>
                <ul class="collapse submenu list-unstyled" id="app">
                    <li class="w-100">
                        <a href="{{ route('resumes.index') }}" class="nav-link menu py-2">
                            <i class="bi bi-file-person me-2"></i>
                            <span>Resume</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('vcards.index') }}" class="nav-link menu py-2">
                            <i class="bi bi-person-vcard me-2"></i>
                            <span>VCard</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('qrcodes.index') }}" class="nav-link menu py-2">
                            <i class="bi bi-qr-code me-2"></i>
                            <span>Qrcodes</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('business.index') }}" class="nav-link menu py-2">
                            <i class="bi bi-briefcase me-2"></i>
                            <span>Business</span>
                        </a>
                    </li>
                    <hr class="sidebar-divider">
                    <li class="w-100">
                        <a href="{{ route('factures.index') }}" class="nav-link menu py-2">
                            <i class="bi bi-receipt me-2"></i>
                            <span>Facture</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('devis.index') }}" class="nav-link menu py-2">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            <span>Devis</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('contrats.index') }}" class="nav-link menu py-2">
                            <i class="bi bi-file-earmark me-2"></i>
                            <span>Contrats</span>
                        </a>
                    </li>
                    <hr class="sidebar-divider">
                    <li class="w-100">
                        <a href="{{ route('emails.index') }}" class="nav-link menu py-2">
                            <i class="bi bi-envelope me-2"></i>
                            <span>Email</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item w-100">
                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link menu px-3 py-2">
                    <i class="bi bi-people me-2"></i>
                    <span class="menu-title">OTHERS</span>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu1">
                    <li class="w-100">
                        <a href="#" class="nav-link menu py-2">
                            <i class="bi bi-person-plus me-2"></i>
                            <span>New others</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="#" class="nav-link menu py-2">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            <span>Others List</span>
                        </a>
                    </li>
                </ul>
            </li> --}}

            @foreach ($modules as $module)
                <li class="nav-item w-100">
                    @include('components.menu', ['module' => $module])
                </li>
            @endforeach

            @php
                $menus = App\Models\Menu::all();
            @endphp


            <li class="nav-item w-100">
                <a href="#menus" data-bs-toggle="collapse"
                    class="nav-link menu px-3 py-2 d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center">
                        <i class="bi bi-menu-up me-2"></i>
                        <span class="menu-title">Menu</span>
                    </span>
                </a>
                <ul class="collapse submenu list-unstyled" id="menus">
                    @foreach ($menus as $menu)
                        <li class="nav-item w-100">
                            <a href="#menu{{ $menu->id }}" data-bs-toggle="collapse"
                                class="nav-link menu px-3 py-2 d-flex align-items-center justify-content-between">
                                <span class="d-flex align-items-center">
                                    <i class="bi bi-menu-app me-2"></i>
                                    <span class="menu-title">{{ $menu->designation }}</span>
                                </span>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="menu{{ $menu->id }}">
                                @foreach ($menu->Plats ?? [] as $plat)
                                    <li class="w-100">
                                        <a href="{{ url("/#$plat->id") }}" class="nav-link menu px-3 py-2">
                                            <i class="bi bi-egg-fried me-2"></i>
                                            <span class="menu-title">{{ $plat->designation }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>


            {{-- <li class="nav-item w-100">
                <a href="#submenu2" data-bs-toggle="collapse" class="nav-link menu px-3 py-2">
                    <i class="bi bi-graph-up me-2"></i>
                    <span class="d-none d-sm-inline">Analytics</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse submenu" id="submenu2">
                    <li class="w-100">
                        <a href="#" class="nav-link menu px-3 py-2">
                            <i class="bi bi-bar-chart me-2"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="#" class="nav-link menu px-3 py-2">
                            <i class="bi bi-pie-chart me-2"></i>
                            <span>Statistics</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item w-100">
                <a href="#submenu3" data-bs-toggle="collapse" class="nav-link menu px-3 py-2">
                    <i class="bi bi-gear me-2"></i>
                    <span class="d-none d-sm-inline">Settings</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse submenu" id="submenu3">
                    <li class="w-100">
                        <a href="#" class="nav-link menu px-3 py-2">
                            <i class="bi bi-person-gear me-2"></i>
                            <span>Account</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="#" class="nav-link menu px-3 py-2">
                            <i class="bi bi-shield-check me-2"></i>
                            <span>Security</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </div>
</div>
