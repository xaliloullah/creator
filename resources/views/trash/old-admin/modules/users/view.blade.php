@extends('dashboard.index')
@section('title', 'Utilisateurs')
@section('title2', 'Details')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Details de l'utilisateur</h1>
            <p class="text-muted mb-0">Afficher les informations complètes sur l'utilisateur</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-pencil"></i><span class="d-none d-sm-inline ms-2">Modifier</span>
            </a>
            <a href="{{ route('users.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="user-info-tab" data-bs-toggle="tab" data-bs-target="#user-info"
                        type="button" role="tab" aria-controls="user-info" aria-selected="true">Informations
                        générales</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security"
                        type="button" role="tab" aria-controls="security" aria-selected="true">Sécurité &
                        Connexion</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="roles-permissions-tab" data-bs-toggle="tab"
                        data-bs-target="#roles-permissions" type="button" role="tab" aria-controls="roles-permissions"
                        aria-selected="true">Roles &
                        Permissions</button>
                </li>
            </ul>
            <div class="tab-content" id="components-content">
                <div class="tab-pane fade show active" id="user-info" role="tabpanel" aria-labelledby="user-info-tab"
                    tabindex="0">
                    <div class="card border-0 shadow-sm mt-3 mb-4">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">Prenom</label>
                                    <span class="fs-5">{{ $user->prenom }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">Nom</label>
                                    <span class="fs-5">{{ $user->nom }}</span>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="small text-muted d-block">Description</label>
                                    <p class="mb-0">Sample product description with detailed information about features
                                        and
                                        specifications.</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">Email</label>
                                    <span>{{ $user->email }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-muted d-block">telephone</label>
                                    <span>{{ $user->telephone }}</span>
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
                                        {!! $user->description !!}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="small text-muted d-block">Statut</label>
                                        @component('components.tags', ['badge' => $user->statut])
                                        @endcomponent
                                    </div>

                                    <div class="col-12">
                                        <label class="small text-muted d-block">Tags</label>
                                        @component('components.tags', ['tags' => $user->tags])
                                        @endcomponent
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab" tabindex="0">
                    <div class="card border-0 shadow-sm mb-4 mt-4">
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
                    </div>
                </div>
                <div class="tab-pane fade" id="roles-permissions" role="tabpanel"
                    aria-labelledby="roles-permissions-tab" tabindex="0">
                    <div class="card border-0 shadow-sm mt-3 mb-4">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h5 class="mb-3">Permissions & Roles</h5>
                                <div class="col-12 mb-3">
                                    <label class="small text-muted d-block">Roles de l'utilisateur</label>
                                    @component('components.tags', ['badges' => $user->roles])
                                    @endcomponent
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="small text-muted d-block">Permissions de l'utilisateur</label>
                                    @component('components.tags', ['badges' => $user->getAllPermissions()])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                    </div>
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
                                @foreach ($user->roles as $role)
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
                    <h5 class="mb-3">Photo de profil</h5>
                    <img src="{{ asset('assets/images/' . $user->image()) }}" alt="profil"
                        class="image-preview rounded img-square profil mx-auto d-block" />
                </div>
            </div>

            <!-- Record Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Record Information</h5>
                    <h6 class="mb-0">Date de création</h6>
                    <small class="text-muted">{{ $user->created_at }}</small>
                    <h6 class="mt-3 mb-0">Date de modification</h6>
                    <small class="text-muted">{{ $user->updated_at }}</small>
                    {{--
                        <dl class="row mb-0">
                            <dt class="col-sm-6">Created</dt>
                            <dd class="col-sm-6 text-muted">{{ $user->created_at }}</dd>

                            <dt class="col-sm-6">Modified</dt>
                            <dd class="col-sm-6 text-muted">{{ $user->updated_at }}</dd>
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
                Details du user
                <a href="{{ route('users.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
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
                        <img src="{{ asset('assets/images/' . ($user->image ? 'users/' . $user->image : 'default-user.png')) }}"
                            alt="img" class="rounded" width="150px" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="prenom">Prénom:</label>
                        <span>{{ $user->prenom }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="nom">Nom:</label>
                        <span>{{ $user->nom }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="email">Email:</label>
                        <span><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="adresse">Adresse:</label>
                        <span>{{ $user->adresse }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="pays">Pays:</label>
                        <span>
                            {{ $user->pays }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="ville">Ville:</label>
                        <span>{{ $user->ville }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="code_postal">Code Postal:</label>
                        <span>{{ $user->code_postal }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="telephone">Téléphone:</label>
                        <span><a href="tel:{{ $user->telephone }}">{{ $user->telephone }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="mobile">Mobile:</label>
                        <span><a href="tel:{{ $user->mobile }}">{{ $user->mobile }}</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="entreprise">Entreprise:</label>
                        <span>{{ $user->entreprise }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="genre">Genre:</label>
                        <span>{{ $user->genre }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-secondary" for="site_web">Site web:</label>
                        <span><a target="_blank" href="{{ $user->site_web }}">{{ $user->site_web }}</a></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-secondary" for="biographie">Biographie:</label>
                        <span>{!! $user->biographie !!}</span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
