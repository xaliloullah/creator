@extends('dashboard.index')
@section('title', 'Access')
@section('subtitle', 'Modifier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un Acces</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations du acces en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('access.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('access.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @yield('section')
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
