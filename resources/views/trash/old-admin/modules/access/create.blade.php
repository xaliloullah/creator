@extends('dashboard.index')
@section('title', 'Access')
@section('title2', 'Nouveau')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gestion des Rôles et Permissions</h1>
            <p class="text-muted mb-0">
                Gérez les rôles et les permissions des utilisateurs.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('access.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->

    <div class="row">
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles"
                        type="button" role="tab" aria-controls="roles" aria-selected="true">Roles</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="permission-tab" data-bs-toggle="tab" data-bs-target="#permission"
                        type="button" role="tab" aria-controls="permission" aria-selected="false">Permissions</button>
                </li>
            </ul>
            <div class="tab-content" id="components-content">
                <div class="tab-pane fade show active" id="roles" role="tabpanel" aria-labelledby="roles-tab"
                    tabindex="0">
                    @include('admin.modules.access.roles.create')
                </div>
                <div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tab" tabindex="0">
                    @include('admin.modules.access.permissions.create')
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-ghost shadow-lg sticky-top">
                <div class="card-body p-4">
                    <h5 class="mb-3">Aide</h5>
                    <div class="alert alert-info mb-0">
                        <h6 class="alert-heading">
                            <i class="bi bi-info-circle me-2"></i>Conseils
                        </h6>
                        <ul class="mt-2 mb-0 ps-3">
                            <li class="mb-1">Assurez-vous de remplir tous les champs obligatoires (<span
                                    class="text-danger">*</span>).</li>
                            <li class="mb-1">Sélectionnez les permissions appropriées pour le rôle.</li>
                            <li>En cas de problème, contactez l'administrateur du système.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
