@extends('auth.index')
@section('title', 'Connexion')
@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4"> 
                    <img class="img-fluid img-sm" src="{{ asset('assets/images/logo.png') }}" alt="">
                    <h1 class="h3 mb-3">Content de vous revoir !</h1>
                    <p class="text-muted">Connectez-vous à votre compte</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="validate">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email"
                            placeholder="Entrez votre adresse e-mail..." type="email" name="email"
                            value="{{ old('email') }}" autofocus autocomplete="username" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="Mot de passe"
                                name="password" autocomplete="current-password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Mot de passe oublié ?</a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Se connecter</button>
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
                            <div class="text-center">
                                <h1 class="h4 mb-4">Content de vous revoir !</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control form-control-user" id="exampleInputEmail"
                                        aria-describedby="emailHelp" placeholder="Entrez votre adresse e-mail..."
                                        type="email" name="email" value="{{ old('email') }}" required autofocus
                                        autocomplete="username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="exampleInputPassword"
                                        placeholder="Mot de passe" name="password" required autocomplete="current-password">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="remember_me"
                                            name="remember">
                                        <label class="custom-control-label" for="remember_me">Se souvenir de moi</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Connexion
                                </button>
                                <hr>
                                <a href="#" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Connexion avec Google
                                </a>
                                <a href="#" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Connexion avec Facebook
                                </a>
                            </form>
                            <hr>
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="small" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                                </div>
                            @endif
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
