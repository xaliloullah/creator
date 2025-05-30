@extends('dashboard.index')
@section('title', 'Utilisateurs')
@section('title2', 'Modifier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un utilisateur</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations de l'utilisateur en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-eye"></i><span class="d-none d-sm-inline ms-2">Consulter</span>
            </a>
            <a href="{{ route('users.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="validate">
        @csrf
        @method('PUT')
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
                            data-bs-target="#roles-permissions" type="button" role="tab"
                            aria-controls="roles-permissions" aria-selected="true">Roles &
                            Permissions</button>
                    </li>
                </ul>
                <div class="tab-content" id="components-content">
                    <div class="tab-pane fade show active" id="user-info" role="tabpanel" aria-labelledby="user-info-tab"
                        tabindex="0">
                        <div class="card border-0 shadow-sm mt-3 mb-4">
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <h5 class="mb-3">Informations générales</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="prenom" name="prenom"
                                                placeholder="Prénom" value="{{ old('prenom', $user->prenom) }}" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom"
                                                placeholder="Nom" value="{{ old('nom', $user->nom) }}" />
                                        </div>
                                        <div class="col-md-12 ">
                                            <label class="form-label">E-mail <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="E-mail" value="{{ old('email', $user->email) }}" required />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Adresse</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                                <input type="text" class="form-control"
                                                    placeholder="Numéro de rue, nom de la rue" id="rue"
                                                    name="adresse[rue]"
                                                    value="{{ old('adresse.rue', $user->adresse['rue']) }}">
                                                <span class="input-group-text"><i class="bi bi-house-add"></i></span>
                                                <input type="text" class="form-control"
                                                    placeholder="Complément d'adresse (facultatif)" id="complement"
                                                    name="adresse[complement]"
                                                    value="{{ old('adresse.complement', $user->adresse['complement']) }}">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                                <input type="text" class="form-control" placeholder="Ville"
                                                    id="ville" name="adresse[ville]"
                                                    value="{{ old('adresse.ville', $user->adresse['ville']) }}">
                                                <span class="input-group-text"><i class="bi bi-mailbox"></i></span>
                                                <input type="text" class="form-control" placeholder="Code Postal"
                                                    id="code_postal" name="adresse[code_postal]"
                                                    value="{{ old('adresse.code_postal', $user->adresse['code_postal']) }}">
                                                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                                <input type="text" class="form-control" placeholder="Pays"
                                                    id="pays" name="adresse[pays]"
                                                    value="{{ old('adresse.pays', $user->adresse['pays']) }}">
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
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control editor" name="description" rows="5"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Status</label>
                                            @foreach ($statuts as $statut)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="statut"
                                                        id="statut-{{ $statut->value }}" value="{{ $statut->value }}"
                                                        @if (old('statut', $user->statut->value) == $statut->value) checked @endif />
                                                    <label class="form-check-label badge bg-{{ $statut->color }}"
                                                        for="statut-{{ $statut->value }}"><i
                                                            class="bi {{ $statut->icon }}"></i>{{ $statut->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Tags</label>
                                            <select class="form-select tags" multiple name="tags[]">
                                                @foreach ($user->tags as $tag)
                                                    <option value="{{ $tag }}" selected>{{ $tag }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab"
                        tabindex="0">
                        <div class="card border-0 shadow-sm mb-4 mt-4">
                            <div class="card-body p-4">
                                <div class="mt-4">
                                    <h5 class="mb-3">Sécurité & Connexion</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Mot de passe</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Mot de passe" />
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="togglePassword">
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
                                        <label class="form-label">Roles</label>
                                        <select class="form-select tags" multiple name="roles[]">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    @if (in_array($role->name, old('roles', $user->roles->pluck('name')->toArray()))) selected @endif>
                                                    <i class="bi {{ $role->icon }}"></i> {{ $role->designation }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Permissions</label>
                                        <select class="form-select tags" multiple name="permissions[]">
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->name }}"
                                                    @if (in_array($permission->name, old('permissions', $user->permissions->pluck('name')->toArray()))) selected @endif>
                                                    <i class="bi {{ $permission->icon }}"></i>
                                                    {{ $permission->designation }}
                                                </option>
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
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form class="needs-validation" novalidate>
                        <input type="hidden" name="csrfmiddlewaretoken" value="your-csrf-token">
                        <input type="hidden" name="id" value="1">

                        <!-- Basic Information -->
                        <div class="mb-4">
                            <h5 class="mb-3">Basic Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="Sample Product"
                                        required>
                                    <div class="invalid-feedback">Please enter a product name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" name="category" required>
                                        <option value="">Select category...</option>
                                        <option value="electronics" selected>Electronics</option>
                                        <option value="clothing">Clothing</option>
                                        <option value="food">Food</option>
                                        <option value="books">Books</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a category.</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3">Sample product description</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Inventory -->
                        <div class="mb-4">
                            <h5 class="mb-3">Pricing & Inventory</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="price" step="0.01"
                                            value="99.99" required>
                                    </div>
                                    <div class="invalid-feedback">Please enter a valid price.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="stock" value="50" required>
                                    <div class="invalid-feedback">Please enter stock quantity.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" name="sku" value="PROD-001">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Barcode</label>
                                    <input type="text" class="form-control" name="barcode" value="123456789">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="mb-4">
                            <h5 class="mb-3">Additional Details</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number" class="form-control" name="weight" step="0.01" value="1.5">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Brand</label>
                                    <input type="text" class="form-control" name="brand" value="Sample Brand">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Tags</label>
                                    <input type="text" class="form-control" name="tags"
                                        value="electronics, gadget, tech" placeholder="Separate tags with commas">
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <h5 class="mb-3">Status</h5>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusActive"
                                    value="active" checked>
                                <label class="form-check-label" for="statusActive">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusDraft"
                                    value="draft">
                                <label class="form-check-label" for="statusDraft">Draft</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusInactive"
                                    value="inactive">
                                <label class="form-check-label" for="statusInactive">Inactive</label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <a href="index.html" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div> --}}
            </div>

            <!-- Side Panel -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Photo de profil</h5>
                        <div class="text-center mb-3">
                            <div class="image-container rounded-circle img-lg">
                                <img src="{{ asset('assets/images/' . $user->image()) }}" alt="profil"
                                    class="image-preview img-square profil mx-auto d-block" />
                                {{-- {{ asset('assets/images/' . ($user->image ? 'users/' . $user->image : 'default-user.png')) }} --}}
                                <label for="profil" class="image-overlay">
                                    <i class="bi bi-camera-fill fs-3"></i>
                                </label>
                                <input type="file" id="profil" accept="image/*" class="image-input"
                                    name="image" />
                            </div>
                        </div>
                        <div class="d-grid">
                            <label for="profil" class="btn btn-outline-dark">
                                <i class="bi bi-upload"></i><span class="ms-2">Télécharger une image</span>
                            </label>
                        </div>
                        <small class="text-muted d-block text-center mt-2">Maximum file size: 2MB</small>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Informations d'enregistrement</h5>
                        <dl class="row mb-0">
                            <h6 class="mb-0">Date de création</h6>
                            <small class="text-muted">{{ formatDateTime($user->created_at) }}</small>
                            <h6 class="mt-3 mb-0">Date de modification</h6>
                            <small class="text-muted">{{ formatDateTime($user->updated_at) }}</small>
                        </dl>
                    </div>
                </div>
                <div class="card card-ghost border-0 shadow-lg sticky-top">
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
                                <li>En cas de problème, contactez l'administrateur.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        <script src="{{ asset('assets/js/password.js') }}"></script>
    @endpush
@endsection
