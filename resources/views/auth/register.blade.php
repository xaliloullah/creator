@extends('auth.index')

@section('title', 'Inscription')

@section('content')
    <div class="col-sm-10 col-md-8 col-lg-8 col-xl-8">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-code-slash fs-1 text-primary"></i>
                    <h1 class="h3 mb-3">Créer un compte</h1>
                    <p class="text-muted">Rejoignez notre communauté dès aujourd'hui</p>
                </div>
                <form method="POST" action="{{ route('register') }}" class="validate">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom"
                                placeholder="Entrez votre prénom" value="{{ old('prenom') }}" required autofocus
                                autocomplete="given-name">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom"
                                placeholder="Entrez votre nom" value="{{ old('nom') }}" required
                                autocomplete="family-name">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Entrez votre adresse e-mail" value="{{ old('email') }}" required
                                autocomplete="email">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Choisissez un mot de passe" required autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmez le mot de passe</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Répétez le mot de passe" required
                                    autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-5 mb-3">S'inscrire</button>
                        <p class="text-center mb-0">
                            Vous avez déjà un compte ? <a href="{{ route('login') }}"
                                class="text-decoration-none">Connectez-vous</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
