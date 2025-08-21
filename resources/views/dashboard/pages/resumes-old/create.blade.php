@extends('dashboard.index')
@section('title', 'resumes')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Ajouter une resume
                <a href="{{ route('resumes.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('resumes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="form-label" for="profil">Profil</label>
                        <div class="image-preview">
                            <input class="d-none" name="image" id="image" type="file" />
                            @if (auth()->user()->image ?? null)
                                <img src="{{ asset('storage/images/users/' . auth()->user()->image) }}" alt="img"
                                    id="preview-image" />
                            @else
                                <img src="{{ asset('assets/images/default-user.png') }}" alt="img"
                                    id="preview-image" />
                            @endif

                            <label for="image" class="btn btn-sm btn-secondary btn-edit" id="btn-edit">
                                <i class="fa fa-edit"></i>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="prenom">Prenom</label>
                        <input class="form-control" id="prenom" name="prenom" type="text"
                            value="{{ old('prenom', auth()->user()->prenom) }}" required autocomplete="prenom">
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="nom">Nom</label>
                        <input class="form-control" id="nom" name="nom" type="text"
                            value="{{ old('nom', auth()->user()->nom) }}" autocomplete="nom">
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="email">Email</label>
                        <input id="email" name="email" type="email" class="form-control"
                            value="{{ old('email', auth()->user()->email) }}" required autocomplete="username">
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="titre">Titre</label>
                        <input class="form-control" id="titre" name="titre" type="text" placeholder="Titre">
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="permis">Permis</label>
                        <select class="form-control form-control-sm select-multiple" id="permis" name="permis[]"
                            multiple="multiple">
                            {{-- @foreach (['A1', 'A2', 'A', 'B', 'B1', 'B+E', 'C', 'C+E', 'D', 'D+E', 'F', 'BE', 'L', 'M', 'Permis probatoire', 'Permis international'] as $permi)
                                <option value="{{ $permi }}">{{ $permi }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="telephone">Telephone</label>
                        <input class="form-control" id="telephone" name="telephone[0]" type="text"
                            value="{{ auth()->user()->telephone }}">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rue">Numéro de rue, nom de la rue</label>
                            <input type="text" class="form-control" placeholder="Numéro de rue, nom de la rue"
                                id="rue" name="adresse[rue]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="complement">Complément d'adresse (facultatif)</label>
                            <input type="text" class="form-control" placeholder="Complément d'adresse (facultatif)"
                                id="complement" name="adresse[complement]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code_postal">Code postal</label>
                            <input type="text" class="form-control" placeholder="Code Postal" id="code_postal"
                                name="adresse[code_postal]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ville">Ville</label>
                            <input type="text" class="form-control" placeholder="Ville" id="ville"
                                name="adresse[ville]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pays">Pays</label>
                            <input type="text" class="form-control" placeholder="Pays" id="pays"
                                name="adresse[pays]">
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="reset" class="btn btn-danger">Annuler</button>
                    <button type="submit" class="btn btn-success">Continuer</button>
                </div>
            </form>
        </div>
    </div>
@endsection
