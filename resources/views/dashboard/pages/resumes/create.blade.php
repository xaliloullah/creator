@extends('dashboard.index')
@section('title', 'Resumes')
@section('subtitle', 'Nouveau')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajouter une nouvelle resume</h1>
            <p class="text-muted mb-0">
                Remplissez le formulaire ci-dessous pour creer un resume.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('resumes.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data" class="validate">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Informations générales</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="prenom" name="prenom"
                                        placeholder="Prénom" value="{{ old('prenom') }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom"
                                        placeholder="Nom"value="{{ old('nom') }}" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="email" value="{{ old('email') }}" />
                                        <span class="input-group-text">@</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre"
                                        placeholder="Titre" value="{{ old('titre') }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Permis</label>
                                    <select type="text" class="form-control tags" multiple id="permis"
                                        name="permis[]">
                                        @foreach (old('permis', []) as $permis)
                                            <option value="{{ $permis }}">{{ $permis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Telephones</label>
                                    <select class="form-control tags" multiple name="telephones[]">
                                        @foreach (old('telephones', []) as $telephones)
                                            <option value="{{ $telephones }}">{{ $telephones }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Adresse</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        <input type="text" class="form-control"
                                            placeholder="Numéro de rue, nom de la rue" id="rue" name="adresse[rue]"
                                            value="{{ old('adresse.rue') }}">
                                        <span class="input-group-text"><i class="bi bi-house-add"></i></span>
                                        <input type="text" class="form-control"
                                            placeholder="Complément d'adresse (facultatif)" id="complement"
                                            name="adresse[complement]" value="{{ old('adresse.complement') }}">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                        <input type="text" class="form-control" placeholder="Ville" id="ville"
                                            name="adresse[ville]" value="{{ old('adresse.ville') }}">
                                        <span class="input-group-text"><i class="bi bi-mailbox"></i></span>
                                        <input type="text" class="form-control" placeholder="Code Postal"
                                            id="code_postal" name="adresse[code_postal]"
                                            value="{{ old('adresse.code_postal') }}">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="text" class="form-control" placeholder="Pays" id="pays"
                                            name="adresse[pays]" value="{{ old('adresse.pays') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <h5 class="mb-3">Styles</h5>
                            <div class="col-md-6">
                                <label class="form-label" for="parametre[primary]">Couleur Primaire</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0"
                                        value="{{ old('parametre.primary', '#4e73df') }}" id="parametre[primary]"
                                        name="parametre[primary]" title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #4e73df" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="parametre[secondary]">Couleur Secondaire</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0"
                                        value="{{ old('parametre.secondary', '#858796') }}" id="parametre[secondary]"
                                        name="parametre[secondary]" title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #858796" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="parametre[background]">Couleur Arrière plan</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0"
                                        value="{{ old('parametre.background', '#f8f9fc') }}" id="parametre[background]"
                                        name="parametre[background]" title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #f8f9fc" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="parametre[foreground]">Couleur Premier plan</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0"
                                        value="{{ old('parametre.foreground', '#ffffff') }}" id="parametre[foreground]"
                                        name="parametre[foreground]" title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #ffffff" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Informations supplémentaires</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Statut : </label>
                                    {{-- @component('components.tags', ['badges' => $statuts])
                                    @endcomponent --}}
                                    @foreach ($statuts ?? [] as $statut)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="statut"
                                                id="statut-{{ $statut->value }}" value="{{ $statut->value }}"
                                                @if (old('statut') == $statut->value) checked @endif required />
                                            <label class="form-check-label badge bg-{{ $statut->color }}"
                                                for="statut-{{ $statut->value }}">{{ $statut->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control editor-simple" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                                </div>
                                {{-- <div class="col-12">
                                    <label class="form-label">Conditions</label>
                                    <select class="form-select tags" multiple name="condition[]">
                                        @foreach (old('condition', []) as $condition)
                                            <option value="{{ $condition }}" selected>{{ $condition }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-12">
                                    <label class="form-label">Tags</label>
                                    <select class="form-select tags" multiple name="tags[]">
                                        @foreach (old('tags', []) as $tags)
                                            <option value="{{ $tags }}" selected>{{ $tags }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="popular"
                                            name="parametre[popular]" @if (old('parametre.popular', $resume->parametre['popular'] ?? false)) checked @endif>
                                        <label class="form-check-label" for="popular">Marquer comme resume
                                            populaire</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Permissions & Roles</h5>
                            <div class="col-12 mb-3">
                                <label class="form-label">Roles</label>
                                <select class="form-select tags-option" multiple name="roles[]">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            @if (old('roles') == $role->name) selected @endif><i
                                                class="bi {{ $role->icon }}"></i>{{ $role->designation }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Permissions</label>
                                <select class="form-select tags-option" multiple name="permissions[]">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}"
                                            @if (old('permissions') == $permission->name) selected @endif><i
                                                class="bi {{ $permission->icon }}"></i>{{ $permission->designation }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card card-ghost shadow-lg sticky-bottom">
                    <div class="card-body p-3">
                        <div class="d-flex gap-2 float-end">
                            <button type="reset" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i>Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Image</h5>
                        <div class="text-center mb-3">
                            <div class="image-container rounded-circle img-lg shadow">
                                <img src="{{ asset('assets/images/default-user.png') }}" alt="image"
                                    class="image-preview img-square image mx-auto d-block" />
                                <label for="image" class="image-overlay">
                                    <i class="bi bi-camera-fill fs-3"></i>
                                </label>
                                <input type="file" id="image" accept="image/*" class="image-input"
                                    name="image" />
                            </div>
                        </div>
                        <div class="d-grid">
                            <label for="image" class="btn btn-outline-dark">
                                <i class="bi bi-upload"></i><span class="ms-2">Télécharger une image</span>
                            </label>
                        </div>
                        <small class="text-muted d-block text-center mt-2">Maximum file size: 2MB</small>
                    </div>
                </div>
                <div class="card card-ghost shadow-lg sticky-top">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Aide</h5>
                        <div class="alert alert-info mb-0">
                            <h6 class="alert-heading">
                                <i class="bi bi-info-circle me-2"></i>Conseils
                            </h6>
                            <ul class="mt-2 mb-0 ps-3">
                                <li class="mb-1">Assurez-vous de remplir tous les champs obligatoires (<span
                                        class="text-danger">*</span>).</li>
                                <li class="mb-1">Vérifiez les informations saisies avant de valider.</li>
                                <li>En cas de problème, contactez l'administrateur du système.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
