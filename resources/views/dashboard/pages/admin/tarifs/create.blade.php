@extends('dashboard.index')
@section('title', 'Tarifs')
@section('title2', 'Nouveau')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajouter une nouvelle tarif</h1>
            <p class="text-muted mb-0">
                Remplissez le formulaire ci-dessous pour ajouter un nouvel tarif à l'application.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tarifs.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('tarifs.store') }}" method="POST" enctype="multipart/form-data" class="validate">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Informations générales</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Désignation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="designation" name="designation"
                                        placeholder="Désignation" value="{{ old('designation') }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Durée <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="duree" name="duree"
                                            placeholder="Durée"value="{{ old('duree') }}" required />
                                        <span class="input-group-text">jour(s)</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Prix <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="prix" name="prix"
                                            placeholder="Prix" value="{{ old('prix') }}" required />
                                        <span class="input-group-text">{{ auth()->user()->parametre['devise'] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Reduction</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="reduction" name="reduction"
                                            placeholder="reduction" max="100" value="{{ old('reduction') }}" />
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Styles</h5>
                            <div class="col-md-12">
                                <label class="form-label" for="parametre[color]">Couleur</label>
                                <div class="form-group">
                                    <label for="color-picker" class="form-label visually-hidden">Couleur</label>
                                    <div id="color-picker" class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                                        @foreach ($colors as $color)
                                            <input type="radio" class="btn-check" name="parametre[color]"
                                                id="{{ $color->value }}" value="{{ $color->value }}" autocomplete="off"
                                                @if (old('parametre.color') == $color->value) checked @endif />
                                            <label
                                                class="color-option bg-{{ $color->value }} @if (old('parametre.color') == $color->value) active @endif"
                                                for="{{ $color->value }}" title="{{ $color->name }}"></label>
                                        @endforeach
                                    </div>
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
                                    @foreach ($statuts as $statut)
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
                                    <select class="form-control tags" multiple name="tags[]">
                                        @foreach (old('tags', []) as $tags)
                                            <option value="{{ $tags }}" selected>{{ $tags }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="popular"
                                            name="parametre[popular]" @if (old('parametre.popular', $tarif->parametre['popular'] ?? false)) checked @endif>
                                        <label class="form-check-label" for="popular">Marquer comme tarif
                                            populaire</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Permissions & Roles</h5>
                            <div class="col-12 mb-3">
                                <label class="form-label">Roles</label>
                                <select class="form-control tags-options" multiple name="roles[]">
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
                                <select class="form-control tags-options" multiple name="permissions[]">
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
                </div>
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
