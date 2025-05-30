@extends('auth.index')
@section('title', 'Réinitialisation de mot de passe')
@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-code-slash fs-1 text-primary"></i>
                    <h1 class="h3 mb-3">Réinitialisation de mot de
                        passe</h1>

                    <p class="text-muted"><small>Vous avez oublié votre mot de passe ? Aucun problème. Indiquez-nous
                            simplement votre
                            adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de
                            passe qui vous permettra d'en choisir un nouveau.</small></p>
                </div>
                <form method="POST" action="{{ route('password.email') }}" class="validate">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email"
                            placeholder="Entrez votre adresse e-mail..." type="email" name="email"
                            value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Envoyer</button>
                    <p class="text-center mb-0">
                        Vous n'avez pas de compte ? <a href="{{ route('register') }}" class="text-decoration-none">Créer un
                            compte !</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="p-5 d-flex justify-content-center align-items-center" style="height: 100%;">
                            <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center mb-3">
                                <h1 class="h4 mb-4">Réinitialisation de mot de
                                    passe</h1>
                                <small>Vous avez oublié votre mot de passe ? Aucun problème. Indiquez-nous simplement votre
                                    adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de
                                    passe qui vous permettra d'en choisir un nouveau.</small>
                            </div>
                            <form class="user" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control form-control-user" id="exampleInputEmail"
                                        aria-describedby="emailHelp" placeholder="Entrez votre adresse e-mail..."
                                        type="email" name="email" value="{{ old('email') }}" required autofocus
                                        autocomplete="username">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Lien de réinitialisation du mot de passe par e-mail
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('register') }}">Créer un compte !</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
