@extends('dashboard.index')
@section('title', 'postes')
@section('subtitle', 'Modifier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un poste</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations du poste en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>

        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('postes.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('postes.show', $poste->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-eye"></i><span class="d-none d-sm-inline ms-2">Consulter</span>
            </a>
            <a href="{{ route('postes.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('postes.update', $poste->id) }}" method="POST" enctype="multipart/form-data" class="validate">
        @csrf
        @method('PUT')
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
                                        placeholder="Désignation" value="{{ old('designation', $poste->designation) }}"
                                        required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Salaire</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="salaire" name="salaire"
                                            placeholder="salaire" value="{{ old('salaire', $poste->salaire) }}" />
                                        <span class="input-group-text">{{ auth()->user()->parametre['devise'] }}</span>
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
                                    @foreach ($statuts ?? [] as $statut)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="statut"
                                                id="statut-{{ $statut->value }}" value="{{ $statut->value }}"
                                                @if (old('statut', $poste->statut->value) == $statut->value) checked @endif required />
                                            <label class="form-check-label badge bg-{{ $statut->color }}"
                                                for="statut-{{ $statut->value }}">{{ $statut->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control editor-simple" id="description" name="description" placeholder="Description">{!! old('description', $poste->description) !!}</textarea>
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
                                        @foreach (old('tags', $poste->tags) as $tags)
                                            <option value="{{ $tags }}" selected>{{ $tags }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="new" name="parametre[new]"
                                            @if (old('parametre.new', $poste->parametre['new'] ?? false)) checked @endif>
                                        <label class="form-check-label" for="new">Marquer comme nouveau</label>
                                    </div>
                                </div> --}}
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
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Modifier
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
