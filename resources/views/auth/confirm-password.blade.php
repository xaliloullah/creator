@extends('auth.index')
@section('title', 'Confirmer le mot de passe')
@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-code-slash fs-1 text-primary"></i>
                    <h1 class="h3 mb-3">Confirmer le mot de passe</h1>
                    <p class="text-muted">Veuillez confirmer votre mot de passe
                        avant de continuer.</p>
                </div>
                <form method="POST" action="{{ route('password.confirm') }}" class="validate">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="Mot de passe"
                                name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Mot de passe oublié ?</a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Confirmer</button>
                    <p class="text-center mb-0"> <a href="{{ url()->previous() }}" class="text-decoration-none">Retour</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
