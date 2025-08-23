@extends('errors.index')

@section('title', 'Maintenance en cours')

@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-6">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-tools display-1 text-warning mb-4"></i>
                    <h1 class="display-4 fw-bold mb-4">Maintenance en cours</h1>
                    <p class="lead text-muted mb-4">
                        Notre application est actuellement en maintenance.  
                        Nous travaillons à améliorer le service et serons de retour très bientôt.
                    </p>
                    <p class="text-muted small">
                        Merci de votre patience 🙏
                    </p>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-house-door"></i> Accueil
                    </a>
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-arrow-repeat"></i> Réessayer
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
