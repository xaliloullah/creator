@extends('dashboard.index')
@section('title', 'Clients')
@section('content')
    @php
        $adresse = json_decode($client->adresse, true);
    @endphp
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Details du client
                <a href="{{ route('clients.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <img src="{{ asset('assets/images/' . ($client->image ? 'clients/' . $client->image : 'default-user.png')) }}"
                            alt="img" class="rounded" width="150px" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="prenom">Prénom:</label>
                        <span>{{ $client->prenom }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="nom">Nom:</label>
                        <span>{{ $client->nom }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="email">Email:</label>
                        <span><a href="mailto:{{ $client->email }}">{{ $client->email }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="rue">Rue:</label>
                        <span>{{ $adresse['rue'] }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="complement">complement:</label>
                        <span>{{ $adresse['complement'] }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="code_postal">Code Postal:</label>
                        <span>{{ $adresse['code_postal'] }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="ville">Ville:</label>
                        <span>{{ $adresse['ville'] }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="pays">Pays:</label>
                        <span>
                            {{ $adresse['pays'] }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="telephone">Téléphone:</label>
                        @foreach (json_decode($client->telephones, true) ?? [] as $telephone)
                            <p class="ml-3"><a href="tel:{{ $telephone }}">{{ $telephone }}</a></p>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="entreprise">Entreprise:</label>
                        <span>{{ $client->entreprise }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="civilite">civilite:</label>
                        <span>{{ $client->civilite }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="site_web">Site web:</label>
                        @foreach (json_decode($client->site_web, true) ?? [] as $site_web)
                            <p class="ml-3"><a target="_blank" href="{{ $site_web }}">{{ $site_web }}</a></p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
