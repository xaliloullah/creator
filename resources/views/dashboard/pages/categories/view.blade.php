@extends('dashboard.index')
@section('title', 'categories')
@section('title2', 'Details')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Details du categorie</h1>
            <p class="text-muted mb-0">Informations complètes sur le categorie</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('categories.edit', $categorie->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-pencil"></i><span class="d-none d-sm-inline ms-2">Modifier</span>
            </a>
            <a href="{{ route('categories.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="categorie-info-tab" data-bs-toggle="tab" data-bs-target="#categorie-info"
                        type="button" role="tab" aria-controls="categorie-info" aria-selected="true">Informations
                        générales</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security"
                        type="button" role="tab" aria-controls="security" aria-selected="true">Sécurité &
                        Connexion</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="roles-permissions-tab" data-bs-toggle="tab"
                        data-bs-target="#roles-permissions" type="button" role="tab" aria-controls="roles-permissions"
                        aria-selected="true">Roles &
                        Permissions</button>
                </li> --}}
            </ul>
            <div class="tab-content" id="components-content">
                <div class="tab-pane fade show active" id="categorie-info" role="tabpanel" aria-labelledby="categorie-info-tab"
                    tabindex="0">
                    <div class="card border-0 shadow-sm mt-3 mb-4">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Informations de base</h5>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="small text-muted d-block">Désignation</label>
                                    <span class="fs-5">{{ $categorie->designation }}</span>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="small text-muted d-block">Description</label>
                                    <p class="mb-0">{!! $categorie->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h5 class="mb-3">Informations supplémentaires</h5>
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="small text-muted d-block">Statut</label>
                                        @component('components.tags', ['badge' => $categorie->statut])
                                        @endcomponent
                                    </div>

                                    <div class="col-12">
                                        <label class="small text-muted d-block">Tags</label>
                                        @component('components.tags', ['tags' => $categorie->tags])
                                        @endcomponent
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="col-lg-4">
            <!-- Product Image -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Image</h5>
                    <img src="{{ asset('assets/images/' . $categorie->image) }}" alt="profil"
                        class="image-preview rounded img-square" />
                </div>
            </div>

            <!-- Record Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Record Information</h5>
                    <h6 class="mb-0">Date de création</h6>
                    <small class="text-muted">{{ $categorie->created_at }}</small>
                    <h6 class="mt-3 mb-0">Date de modification</h6>
                    <small class="text-muted">{{ $categorie->updated_at }}</small>
                    {{--
                        <dl class="row mb-0">
                            <dt class="col-sm-6">Created</dt>
                            <dd class="col-sm-6 text-muted">{{ $categorie->created_at }}</dd>

                            <dt class="col-sm-6">Modified</dt>
                            <dd class="col-sm-6 text-muted">{{ $categorie->updated_at }}</dd>
                        </dl>
                            --}}
                </div>
            </div>

            <!-- Related Products -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-3">Related Products</h5>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                            <img src="https://via.placeholder.com/40" alt="" class="rounded">
                            <div>
                                <h6 class="mb-0">Related Product 1</h6>
                                <small class="text-muted">$89.99</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                            <img src="https://via.placeholder.com/40" alt="" class="rounded">
                            <div>
                                <h6 class="mb-0">Related Product 2</h6>
                                <small class="text-muted">$129.99</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                            <img src="https://via.placeholder.com/40" alt="" class="rounded">
                            <div>
                                <h6 class="mb-0">Related Product 3</h6>
                                <small class="text-muted">$79.99</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Details du categorie
                <a href="{{ route('categories.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
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
                        <img src="{{ asset('assets/images/' . ($categorie->image ? 'categories/' . $categorie->image : 'default-categorie.png')) }}"
                            alt="img" class="rounded" width="150px" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="prenom">Prénom:</label>
                        <span>{{ $categorie->prenom }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="nom">Nom:</label>
                        <span>{{ $categorie->nom }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="email">Email:</label>
                        <span><a href="mailto:{{ $categorie->email }}">{{ $categorie->email }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="adresse">Adresse:</label>
                        <span>{{ $categorie->adresse }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="pays">Pays:</label>
                        <span>
                            {{ $categorie->pays }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="ville">Ville:</label>
                        <span>{{ $categorie->ville }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="code_postal">Code Postal:</label>
                        <span>{{ $categorie->code_postal }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="telephone">Téléphone:</label>
                        <span><a href="tel:{{ $categorie->telephone }}">{{ $categorie->telephone }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="mobile">Mobile:</label>
                        <span><a href="tel:{{ $categorie->mobile }}">{{ $categorie->mobile }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="entreprise">Entreprise:</label>
                        <span>{{ $categorie->entreprise }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="genre">Genre:</label>
                        <span>{{ $categorie->genre }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="site_web">Site web:</label>
                        <span><a target="_blank" href="{{ $categorie->site_web }}">{{ $categorie->site_web }}</a></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-secondary" for="biographie">Biographie:</label>
                        <span>{!! $categorie->biographie !!}</span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
