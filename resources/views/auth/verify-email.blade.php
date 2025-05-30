@extends('auth.index')
@section('title', 'Vérification de l\'e-mail')
@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <div class="card border-0 shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-code-slash fs-1 text-primary"></i>
                    <h1 class="h3 mb-3">Vérification de l'e-mail</h1>
                    <p class="text-muted">Merci de votre inscription ! Avant de commencer, pourriez-vous vérifier votre
                        adresse
                        e-mail en cliquant sur le lien que nous venons de vous envoyer par e-mail ? Si vous
                        n'avez pas reçu l'e-mail, nous vous en enverrons volontiers un autre.</p>
                </div>
                <form method="POST" action="{{ route('verification.send') }}" class="validate">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 mb-3">Renvoyer l'e-mail de vérification</button>
                    {{-- <p class="text-center mb-0">
                        Vous n'avez pas de compte ? <a href="{{ route('register') }}" class="text-decoration-none">Créer un
                            compte !</a>
                        </p> --}}
                </form>
                <form class="user" method="POST" action="{{ route('logout') }}" class="validate">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">Se déconnecter</button>
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
                                <h1 class="h4 mb-4">Vérification de l'e-mail</h1>
                                <small>Merci de votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse
                                    e-mail en cliquant sur le lien que nous venons de vous envoyer par e-mail ? Si vous
                                    n'avez pas reçu l'e-mail, nous vous en enverrons volontiers un autre.</small>
                            </div>
                            <form class="user" method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Renvoyer l'e-mail de vérification
                                </button>
                            </form>
                            <hr>
                            <form class="user" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-user btn-block">
                                    Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
