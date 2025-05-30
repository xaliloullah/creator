<!DOCTYPE html>
<html lang="fr">
@section('title', 'Docs')
@include('dashboard.includes.head')

<body>
    <div class="container my-5">
        <h1 class="text-center">📖 Documentation {{ config('app.name') }}</h1>
        <p class="text-center text-muted">Liste des outils et bibliothèques utilisés</p>

        <div class="row row-cols-1 row-cols-md-2 g-4 mt-4">
            <!-- Bootstrap -->
            <div class="col">
                <a href="https://getbootstrap.com/docs/5.3" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-bootstrap fs-1 text-primary me-3"></i>
                            <div>
                                <h5 class="card-title">Bootstrap</h5>
                                <p class="card-text">Framework CSS pour un design responsive et moderne.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Bootstrap Icons -->
            <div class="col">
                <a href="https://icons.getbootstrap.com" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-emoji-smile fs-1 text-warning me-3"></i>
                            <div>
                                <h5 class="card-title">Bootstrap Icons</h5>
                                <p class="card-text">Bibliothèque d'icônes pour Bootstrap.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Laravel -->
            <div class="col">
                <a href="https://laravel.com/docs/11.x" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-code-slash fs-1 text-danger me-3"></i>
                            <div>
                                <h5 class="card-title">Laravel</h5>
                                <p class="card-text">Framework PHP puissant et élégant.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- SweetAlert2 -->
            <div class="col">
                <a href="https://sweetalert2.github.io" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle fs-1 text-danger me-3"></i>
                            <div>
                                <h5 class="card-title">SweetAlert2</h5>
                                <p class="card-text">Bibliothèque pour des alertes stylées.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tom Select -->
            <div class="col">
                <a href="https://tom-select.js.org" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-check-all fs-1 text-success me-3"></i>
                            <div>
                                <h5 class="card-title">Tom Select</h5>
                                <p class="card-text">Composant avancé pour les sélections.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- DataTables -->
            <div class="col">
                <a href="https://cdn.datatables.net" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-table fs-1 text-info me-3"></i>
                            <div>
                                <h5 class="card-title">DataTables</h5>
                                <p class="card-text">Gestion des tableaux dynamiques.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- TinyMCE -->
            <div class="col">
                <a href="https://www.tiny.cloud/docs/tinymce/latest/getting-started" target="_blank"
                    class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-alphabet fs-1 text-primary me-3"></i>
                            <div>
                                <h5 class="card-title">TinyMCE</h5>
                                <p class="card-text">Éditeur de texte riche.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- API Devise -->
            <div class="col">
                <a href="https://api.exchangerate-api.com/v4/latest/XOF" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-currency-exchange fs-1 text-secondary me-3"></i>
                            <div>
                                <h5 class="card-title">API Devise</h5>
                                <p class="card-text">Conversion des devises en temps réel.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Livewire -->
            <div class="col">
                <a href="https://livewire.laravel.com/" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-infinity fs-1 text-purple me-3"></i>
                            <div>
                                <h5 class="card-title">Livewire</h5>
                                <p class="card-text">Composants interactifs pour Laravel.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="#components-modal" data-bs-toggle="modal" data-bs-target="#components-modal"
                    class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-boxes fs-1 text-info me-3"></i>
                            <div>
                                <h5 class="card-title">Components</h5>
                                <p class="card-text">Composants pour {{ config('app.name') }}.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('test') }}" target="_blank" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-file fs-1 text-primary me-3"></i>
                            <div>
                                <h5 class="card-title">Test</h5>
                                <p class="card-text">Page de Test.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @include('dashboard.includes.js')
</body>
@component('components.modals.components')
@endcomponent

</html>
