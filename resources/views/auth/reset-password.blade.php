@extends('auth.index')
@section('title', 'Réinitialiser le mot de passe')
@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <img class="img-fluid img-sm" src="{{ asset('assets/images/logo.png') }}" alt="">
                    <h1 class="h3 mb-3">Réinitialiser le mot de passe</h1>
                    {{-- <p class="text-muted">Connectez-vous à votre compte</p> --}}
                </div>
                <form method="POST" action="{{ route('password.store') }}" class="validate">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email"
                            placeholder="Entrez votre adresse e-mail..." type="email" name="email"
                            value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="Mot de passe"
                                name="password" required autocomplete="current-password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="Répétez le mot de passe"
                                name="password_confirmation" autocomplete="new-password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Réinitialiser le mot de passe</button>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="p-5 d-flex justify-content-center align-items-center" style="height: 100%;">
                        <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 mb-4">Réinitialiser le mot de passe</h1>
                        </div>
                        <form class="user" method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" placeholder="Adresse e-mail"
                                    id="email" name="email" value="{{ old('email') }}" required
                                    autocomplete="username">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" placeholder="Mot de passe"
                                        id="password" name="password" required autocomplete="new-password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                        placeholder="Répétez le mot de passe" name="password_confirmation" required
                                        autocomplete="new-password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Réinitialiser le mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
