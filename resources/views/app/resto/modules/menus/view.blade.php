@extends('dashboard.index')
@section('title', 'menus')
@section('title2', 'Details')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Details du menu</h1>
            <p class="text-muted mb-0">Informations complètes sur le menu</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('menus.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-pencil"></i><span class="d-none d-sm-inline ms-2">Modifier</span>
            </a>
            <a href="{{ route('menus.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="menu-info-tab" data-bs-toggle="tab" data-bs-target="#menu-info"
                        type="button" role="tab" aria-controls="menu-info" aria-selected="true">Informations
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
                <div class="tab-pane fade show active" id="menu-info" role="tabpanel" aria-labelledby="menu-info-tab"
                    tabindex="0">
                    <div class="card border-0 shadow-sm mt-3 mb-4">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Informations de base</h5>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="small text-muted d-block">Désignation</label>
                                    <span class="fs-5">{{ $menu->designation }}</span>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="small text-muted d-block">Description</label>
                                    <p class="mb-0">{!! $menu->description !!}</p>
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
                                        @component('components.tags', ['badge' => $menu->statut])
                                        @endcomponent
                                    </div>

                                    <div class="col-12">
                                        <label class="small text-muted d-block">Tags</label>
                                        @component('components.tags', ['tags' => $menu->tags])
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
                    <img src="{{ asset('assets/images/' . $menu->image) }}" alt="profil"
                        class="image-preview rounded img-square" />
                </div>
            </div>

            <!-- Record Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Record Information</h5>
                    <h6 class="mb-0">Date de création</h6>
                    <small class="text-muted">{{ $menu->created_at }}</small>
                    <h6 class="mt-3 mb-0">Date de modification</h6>
                    <small class="text-muted">{{ $menu->updated_at }}</small>
                    {{--
                        <dl class="row mb-0">
                            <dt class="col-sm-6">Created</dt>
                            <dd class="col-sm-6 text-muted">{{ $menu->created_at }}</dd>

                            <dt class="col-sm-6">Modified</dt>
                            <dd class="col-sm-6 text-muted">{{ $menu->updated_at }}</dd>
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
                Details du menu
                <a href="{{ route('menus.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
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
                        <img src="{{ asset('assets/images/' . ($menu->image ? 'menus/' . $menu->image : 'default-menu.png')) }}"
                            alt="img" class="rounded" width="150px" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="prenom">Prénom:</label>
                        <span>{{ $menu->prenom }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="nom">Nom:</label>
                        <span>{{ $menu->nom }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="email">Email:</label>
                        <span><a href="mailto:{{ $menu->email }}">{{ $menu->email }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="adresse">Adresse:</label>
                        <span>{{ $menu->adresse }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="pays">Pays:</label>
                        <span>
                            {{ $menu->pays }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="ville">Ville:</label>
                        <span>{{ $menu->ville }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="code_postal">Code Postal:</label>
                        <span>{{ $menu->code_postal }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="telephone">Téléphone:</label>
                        <span><a href="tel:{{ $menu->telephone }}">{{ $menu->telephone }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="mobile">Mobile:</label>
                        <span><a href="tel:{{ $menu->mobile }}">{{ $menu->mobile }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="entreprise">Entreprise:</label>
                        <span>{{ $menu->entreprise }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="genre">Genre:</label>
                        <span>{{ $menu->genre }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="site_web">Site web:</label>
                        <span><a target="_blank" href="{{ $menu->site_web }}">{{ $menu->site_web }}</a></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-secondary" for="biographie">Biographie:</label>
                        <span>{!! $menu->biographie !!}</span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
