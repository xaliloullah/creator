@extends('errors.index')
@section('title', 'Accès Interdit')
@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-6">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-ban display-1 text-danger mb-4"></i>
                    <h1 class="display-4 fw-bold mb-3">403</h1>
                    <p class="lead text-gray-800 mb-4">Accès Interdit</p>
                    <p class="lead text-muted mb-5">
                        {{ 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.' }}
                        {{-- {{ $exception->getMessage() ?: 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.' }} --}}
                    </p>
                </div>
                <div class="text-center">
                    <a href="{{ url('') }}" class="btn btn-primary btn-lg px-4">&larr; Retour a l'acceuil</a>
                </div>
            </div>
        </div>
    </div>
@endsection
