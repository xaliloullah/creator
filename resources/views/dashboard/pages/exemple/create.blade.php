@extends('admin.index')
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
    <form action="{{ route('tarifs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Informations générales</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nom" name="nom"
                                        placeholder="Nom" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Durée <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="duree" name="duree"
                                            placeholder="Durée" required />
                                        <span class="input-group-text">jour(s)</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Prix <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="prix" name="prix"
                                            placeholder="Prix" required />
                                        <span class="input-group-text">FCFA</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Reduction</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="reduction" name="reduction"
                                            placeholder="reduction" max="100" value="0" />
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
                                        @foreach (['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'light', 'dark'] as $color)
                                            <input type="radio" class="btn-check" name="parametre[color]"
                                                id="{{ $color }}" value="{{ $color }}" autocomplete="off"
                                                @if ($loop->first) checked @endif />
                                            <label
                                                class="color-option bg-{{ $color }} @if ($loop->first) active @endif"
                                                for="{{ $color }}" title="{{ $color }}"></label>
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
                                    <label class="form-label">Etat : </label>
                                    @foreach (['actif' => ['success', true], 'inactif' => ['danger', false]] as $index => $etat)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="etat"
                                                id="etat{{ $index }}" value="{{ $etat[1] }}"
                                                @if ($loop->first) checked @endif />
                                            <label class="form-check-label badge bg-{{ $etat[0] }}"
                                                for="etat{{ $index }}">{{ $index }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control editor" id="description" name="description" placeholder="Description"></textarea>

                                </div>
                                <div class="col-12">
                                    <label class="form-label">Tags</label>
                                    <select class="form-select tags" multiple name="tags">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-transparent ghost-card shadow-lg sticky-bottom">
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
                <div class="card border-0 shadow-sm sticky-top">
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
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const colorPicker = document.getElementById("color-picker");

                colorPicker.addEventListener("change", function(event) {
                    if (event.target.type === "radio") {
                        const selectedColor = event.target.value;

                        document
                            .querySelectorAll(".color-option")
                            .forEach((option) => {
                                option.classList.remove("active");
                            });
                        event.target.nextElementSibling.classList.add("active");
                    }
                });
            });
        </script>
    @endpush
@endsection
