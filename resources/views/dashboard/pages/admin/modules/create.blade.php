@extends('dashboard.index')
@section('title', 'modules')
@section('title2', 'Nouveau')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajouter une nouvelle module</h1>
            <p class="text-muted mb-0">
                Remplissez le formulaire ci-dessous pour ajouter un nouvel module à l'application.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('modules.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('modules.store') }}" method="POST" enctype="multipart/form-data" class="validate">
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
                                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Nom du module"
                                        value="{{ old('name') }}" required>
                                </div> 
                                <div class="col-md-6">
                                    <label class="form-label">Route</label>
                                    <input type="text" name="route" class="form-control" placeholder="Nom de la route"
                                        value="{{ old('route') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Lien</label>
                                    <input type="text" name="link" class="form-control" placeholder="URL externe"
                                        value="{{ old('link') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Cible (target)</label> 
                                        <select name="target" class="form-control">
                                        <option value="" selected disabled>Target</option>
                                        @foreach (['_blank', '_self'] as $target)
                                            <option value="{{ $target }}" @selected(old('target') == $target)>
                                                {{ $target }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Module parent</label>
                                    <select name="module_id" class="form-control">
                                        <option value="">Aucun</option>
                                        @foreach ($modules as $mod)
                                            <option value="{{ $mod->id }}" @selected(old('module_id') == $mod->id)>
                                                {{ $mod->designation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label mb-3" for="icon">Icon</label>
                                    <div class="form-group text-center">
                                        @foreach ($icons as $icon)
                                            <input type="radio" class="btn-check" name="icon" id="{{ $icon }}"
                                                value="{{ $icon }}" @if (old('icon') == $icon) checked @endif
                                                autocomplete="off">
                                            <label
                                                class="btn btn-outline-dark mb-1 @if (old('icon') == $icon) active @endif"
                                                for="{{ $icon }}">
                                                <i class="bi {{ $icon }} fs-4"></i>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="lock" value="1" class="form-check-input"
                                            id="lock" @checked(old('lock'))>
                                        <label for="lock" class="form-check-label">Verrouillé</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="hidden" value="1" class="form-check-input"
                                            id="hidden" @checked(old('hidden'))>
                                        <label for="hidden" class="form-check-label">Caché</label>
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
                                <label class="form-label" for="color">Couleur</label>
                                <div class="form-group">
                                    <label for="color-picker" class="form-label visually-hidden">Couleur</label>
                                    <div id="color-picker" class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                                        @foreach ($colors as $color)
                                            <input type="radio" class="btn-check" name="color"
                                                id="{{ $color->value }}" value="{{ $color->value }}" autocomplete="off"
                                                @checked (old('color') == $color->value) />
                                            <label
                                                class="color-option bg-{{ $color->value }} @if (old('color') == $color->value) active @endif"
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
                                {{-- <div class="col-12">
                                    <label class="form-label">Statut : </label> 
                                    @foreach ($statuts as $statut)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="statut"
                                                id="statut-{{ $statut->value }}" value="{{ $statut->value }}"
                                                @checked(old('statut') == $statut->value) required />
                                            <label class="form-check-label badge bg-{{ $statut->color }}"
                                                for="statut-{{ $statut->value }}">{{ $statut->name }}</label>
                                        </div>
                                    @endforeach
                                </div> --}}
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control editor-simple" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Tags</label>
                                    <select class="form-control tags" multiple name="tags[]">
                                        @foreach (old('tags', []) as $tags)
                                            <option value="{{ $tags }}" selected>{{ $tags }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
