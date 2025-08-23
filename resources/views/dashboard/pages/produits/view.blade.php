@extends('dashboard.index')
@section('title', 'produits')
@section('subtitle', 'Details')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Details de l'produit</h1>
            <p class="text-muted mb-0">Afficher les informations complètes sur le produit</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('produits.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-pencil"></i><span class="d-none d-sm-inline ms-2">Modifier</span>
            </a>
            <a href="{{ route('produits.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="produit-info-tab" data-bs-toggle="tab"
                        data-bs-target="#produit-info" type="button" role="tab" aria-controls="produit-info"
                        aria-selected="true">Informations
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
                <div class="tab-pane fade show active" id="produit-info" role="tabpanel" aria-labelledby="produit-info-tab"
                    tabindex="0">
                    <div class="card border-0 shadow-sm mt-3 mb-4">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Informations de base</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">Désignation</label>
                                    <span class="fs-5">{{ $produit->designation }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">Menu</label>
                                    <span class="fs-5"><a href="{{ route('menus.show', $produit->Menu->id) }}">
                                            {{ $produit->Menu->designation ?? '' }}</a></span>
                                </div>
                                {{-- <div class="col-12 mb-3">
                                    <label class="small text-muted d-block">Description</label>
                                    <p class="mb-0">{!! $produit->description !!}</p>
                                </div> --}}
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">Prix</label>
                                    <span>{{ $produit->prix }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">duree</label>
                                    <span>{{ $produit->duree }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">reduction</label>
                                    <span>{{ $produit->reduction }}</span>
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
                                        <label class="small text-muted d-block">Description</label>
                                        {!! $produit->description !!}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="small text-muted d-block">Statut</label>
                                        @component('components.tags', ['badge' => $produit->statut])
                                        @endcomponent
                                    </div>

                                    <div class="col-12">
                                        <label class="small text-muted d-block">Tags</label>
                                        @component('components.tags', ['tags' => $produit->tags])
                                        @endcomponent
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab" tabindex="0">
                    {{-- <div class="card border-0 shadow-sm mb-4 mt-4">
                        <div class="card-body p-4">
                            <div class="mt-4">
                                <h5 class="mb-3">Sécurité & Connexion</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Mot de passe" />
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Répétez le mot de
                                            passe</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                placeholder="Répétez le mot de passe" name="password_confirmation" />
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="toggleConfirmPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="tab-pane fade" id="roles-permissions" role="tabpanel" aria-labelledby="roles-permissions-tab"
                    tabindex="0">
                    {{-- <div class="card border-0 shadow-sm mt-3 mb-4">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h5 class="mb-3">Permissions & Roles</h5>
                                <div class="col-12 mb-3">
                                    <label class="small text-muted d-block">Roles de l'produit</label>
                                    @component('components.tags', ['badges' => $produit->roles])
                                    @endcomponent
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="small text-muted d-block">Permissions de l'produit</label>
                                    @component('components.tags', ['badges' => $produit->getAllPermissions()])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- Basic Information -->


            {{-- <!-- Pricing & Inventory -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-4">Pricing & Inventory</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="small text-muted d-block">Price</label>
                            <span class="fs-5">$99.99</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small text-muted d-block">Stock</label>
                            <span class="fs-5">50 units</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small text-muted d-block">Status</label>
                            <span class="badge bg-success">Active</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-4">Additional Details</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted d-block">Weight</label>
                            <span>1.5 kg</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted d-block">Brand</label>
                            <span>Sample Brand</span>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted d-block">Roles</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($produit->roles as $role)
                                    <span class="badge bg-{{ $role->color }}"> <i class="{{ $role->icon }} me-2"></i>
                                        {{ $role->designation }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted d-block">Tags</label>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark">electronics</span>
                                <span class="badge bg-light text-dark">gadget</span>
                                <span class="badge bg-light text-dark">tech</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Side Panel -->
        <div class="col-lg-4">
            <!-- Product Image -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Image</h5>
                    <img src="{{ asset('assets/images/' . $produit->image) }}" alt="profil"
                        class="image-preview rounded img-square" />
                </div>
            </div>

            <!-- Record Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Record Information</h5>
                    <h6 class="mb-0">Date de création</h6>
                    <small class="text-muted">{{ $produit->created_at }}</small>
                    <h6 class="mt-3 mb-0">Date de modification</h6>
                    <small class="text-muted">{{ $produit->updated_at }}</small>
                    {{--
                        <dl class="row mb-0">
                            <dt class="col-sm-6">Created</dt>
                            <dd class="col-sm-6 text-muted">{{ $produit->created_at }}</dd>

                            <dt class="col-sm-6">Modified</dt>
                            <dd class="col-sm-6 text-muted">{{ $produit->updated_at }}</dd>
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
@endsection
