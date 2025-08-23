@extends('errors.index')

@section('title', 'Maintenance en cours')

@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-6">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-4 p-md-5 text-center">

                <!-- Icone avec animation AOS -->
                <div class="mb-4" data-aos="zoom-in">
                    <i class="bi bi-tools display-1 text-warning mb-3"></i>
                </div>

                <!-- Titre -->
                <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">
                    Maintenance en cours
                </h1>

                <!-- Texte descriptif -->
                <p class="lead text-muted mb-4" data-aos="fade-up">
                    Notre application est actuellement en maintenance.
                    Nous travaillons à améliorer le service et serons de retour très bientôt.
                </p>
                <p class="text-muted small" data-aos="fade-up">
                    Merci de votre patience
                </p>
                <!-- Boutons -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                    @if (auth()->check())
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" aria-label="Se déconnecter">
                                <i class="bi bi-box-arrow-left"></i> Se déconnecter
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm" aria-label="Se connecter">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter
                        </a>
                    @endif

                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm" aria-label="Réessayer">
                        <i class="bi bi-arrow-repeat"></i> Réessayer
                    </a>

                    <a href="mailto:support@creator.com" class="btn btn-outline-info btn-sm"
                        aria-label="Contacter le support">
                        <i class="bi bi-envelope"></i> Contacter le support
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
