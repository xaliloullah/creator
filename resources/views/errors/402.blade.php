@extends('errors.index')
@section('title', 'Paiement Requis')
@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-6">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-question-circle display-1 text-primary mb-4"></i>
                    <h1 class="display-4 fw-bold mb-3">402</h1>
                    <p class="lead text-gray-800 mb-4">Paiement Requis</p>
                    <p class="lead text-muted mb-5">
                        {{ $exception->getMessage() ?: 'Cette action nécessite un paiement. Veuillez compléter votre paiement pour continuer.' }}
                    </p>
                </div>
                <div class="text-center">
                    <a href="{{ url()->previous() }}" class="btn btn-primary btn-lg px-4">&larr; Retour</a>
                </div>
            </div>
        </div>
    </div>
@endsection
