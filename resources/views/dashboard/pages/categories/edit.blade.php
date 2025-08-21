@extends('dashboard.index')
@section('title', 'categories')
@section('title2', 'Modifier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un categorie</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations du categorie en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>

        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('categories.show', $categorie->id) }}" class="btn btn-outline-dark" target="_blank">
                <i class="bi bi-eye"></i><span class="d-none d-sm-inline ms-2">Consulter</span>
            </a>
            <a href="{{ route('categories.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('categories.update', $categorie->id) }}" method="POST" enctype="multipart/form-data"
        class="validate">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Informations générales</h5>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Désignation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="designation" name="designation"
                                        value="{{ old('designation', $categorie->designation) }}" placeholder="Désignation"
                                        required />
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Catégories</label>
                                    <select class="form-select" name="categorie_id">
                                        <option value="" selected disabled>Catégorie</option>
                                        @include('dashboard.modules.categories.includes.options', [
                                            'categories' => $categories,
                                            'depth' => 0,
                                        ])
                                    </select>
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
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control editor" id="description" name="description" placeholder="Description">{!! $categorie->description !!}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Tags</label>
                                    <select class="form-select tags" multiple name="tags[]">
                                        @foreach ($categorie->tags as $tag)
                                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
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
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-1"></i>Modifier
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
                                <img src="{{ asset('assets/images/' . $categorie->image()) }}" alt="image"
                                    class="image-preview img-square image mx-auto d-block" />
                                <label for="image" class="image-overlay">
                                    <i class="bi bi-camera-fill fs-3"></i>
                                </label>
                                <input type="file" id="image" accept="image/*" class="image-input" name="image" />
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
