<!-- Sidebar -->
<div class="sidebar scrollbar collapse d-md-block shadow bg-light bg-gradient" id="sidebar">
    <div class="d-flex flex-column min-vh-100">
        <ul class="nav flex-column mb-sm-auto mb-0 align-items-start w-100" id="menu">
            @admin
                @foreach ($modules as $module)
                    <li class="nav-item w-100">
                        @include('components.menu', ['module' => $module])
                    </li>
                @endforeach
            @endadmin
            {{-- <li class="nav-item w-100">
                    <a href="#management" data-bs-toggle="collapse" class="nav-link menu px-3 py-2">
                        <i class="bi bi-file-earmark-code-fill me-2"></i>
                        <span class="menu-title">Gestions</span>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="management">
                        <li class="w-100">
                            <a href="{{ route('users.index') }}" class="nav-link menu py-2">
                                <i class="bi bi-people me-2"></i>
                                <span>Utilisateurs</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ route('tarifs.index') }}" class="nav-link menu py-2">
                                <i class="bi bi-emoji-smile me-2"></i>
                                <span>Icon</span>
                            </a>
                        </li>
                    </ul>
                </li> 
            --}}
            @developer
                <li class="nav-item w-100">
                    <a href="#documentations" data-bs-toggle="collapse" class="nav-link menu px-3 py-2">
                        <i class="bi bi-file-earmark-code-fill me-2"></i>
                        <span class="menu-title">DOCUMENTATIONS</span>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="documentations">
                        <li class="w-100">
                            <a href="{{ 'https://getbootstrap.com/docs/5.3' }}" target="_blank" class="nav-link menu py-2">
                                <i class="bi bi-bootstrap me-2"></i>
                                <span>Bootstrap</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ 'https://icons.getbootstrap.com' }}" target="_blank" class="nav-link menu py-2">
                                <i class="bi bi-emoji-smile me-2"></i>
                                <span>Icon</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ 'https://laravel.com/docs/11.x' }}" target="_blank" class="nav-link menu py-2">
                                <i class="bi bi-code-slash me-2"></i>
                                <span>Laravel</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ 'https://sweetalert2.github.io' }}" target="_blank" class="nav-link menu py-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <span>Sweetalert2</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ 'https://tom-select.js.org' }}" target="_blank" class="nav-link menu py-2">
                                <i class="bi bi-check-all me-2"></i>
                                <span>Tom Select</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ 'https://cdn.datatables.net' }}" target="_blank" class="nav-link menu py-2">
                                <i class="bi bi-table me-2"></i>
                                <span>DataTables</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ 'https://www.tiny.cloud/docs/tinymce/latest/getting-started' }}" target="_blank"
                                class="nav-link menu py-2">
                                <i class="bi bi-alphabet me-2"></i>
                                <span>Editor TinyMCE</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ 'https://api.exchangerate-api.com/v4/latest/XOF' }}" target="_blank"
                                class="nav-link menu py-2">
                                <i class="bi bi-currency-exchange me-2"></i>
                                <span>API devise</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ 'https://livewire.laravel.com/' }}" target="_blank" class="nav-link menu py-2">
                                <i class="bi bi-infinity me-2"></i>
                                <span>Livewire</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="#components" data-bs-toggle="modal" data-bs-target="#components-modal"
                                class="nav-link menu py-2">
                                <i class="bi bi-boxes me-2"></i>
                                <span>Components</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ route('test') }}" target="_blank" class="nav-link menu py-2">
                                <i class="bi bi-file me-2"></i>
                                <span>Test</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="w-100">
                    <a href="#components" data-bs-toggle="modal" data-bs-target="#components-modal"
                        class="nav-link menu py-2">
                        <i class="bi bi-boxes me-2"></i>
                        <span>Components</span>
                    </a>
                </li>
                <li class="w-100">
                    <a href="{{ route('test') }}" target="_blank" class="nav-link menu py-2">
                        <i class="bi bi-file me-2"></i>
                        <span>Test</span>
                    </a>
                </li>
            @enddeveloper
        </ul>
    </div>
</div>
