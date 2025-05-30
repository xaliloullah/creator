@extends('dashboard.index')
@section('title', 'Profil')
@section('content')
    {{-- <div class="row mb-3">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center shadow">
                <div class="card-body">
                    <img src="{{ asset('assets/images/' . ($user->image ? 'users/' . $user->image : 'default-user.png')) }}"
                        class="rounded-circle img-profile img-thumbnail" alt="profile-image">

                    <h4 class="mb-0 mt-2">{{ $user->prenom }} {{ $user->nom }}</h4>
                    @if ($user->isAdmin())

                    <p><span class="badge badge-warning">{{ $user->roles }}</span></p>
                    @endif

                    <button type="button" class="btn btn-success btn-sm mb-2">Follow</button>
                    <button type="button" class="btn btn-danger btn-sm mb-2">Message</button>

                    <div class="text-left mt-3 custom-scrollbar-sm">
                        <h6 class="text-uppercase">Bio :</h6>
                        <p class="text-muted mb-3">
                            {!! $user->biographie !!}
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Prenom & Nom : </strong> <span
                                class="ms-2">{{ $user->prenom }} {{ $user->nom }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Telephone : </strong><span
                                class="ms-2">{{ $user->telephone }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Email : </strong> <span
                                class="ms-2 ">{{ $user->email }}</span></p>

                        <p class="text-muted mb-1 font-13"><strong>Adresse : </strong> <span
                                class="ms-2">{{ $user->adresse }}</span>
                        </p>
                    </div>

                    <ul class="social-list list-inline mt-3 mb-0">
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                    class="fab fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                    class="fab fa-google"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                    class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                    class="fab fa-github"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                Timeline
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Paramètres
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content custom-scrollbar">
                        <div class="tab-pane" id="aboutme">
                            {!! $user->experiences !!}
                        </div>

                        <div class="tab-pane show active" id="timeline">
                            <div class="border rounded mt-2 mb-3">
                                <form action="#" class="comment-area-box">
                                    <textarea rows="3" class="form-control border-0 resize-none" placeholder="Write something...."></textarea>
                                    <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                    class="fab fa-account-circle"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                    class="fab fa-map-marker"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                    class="fab fa-camera"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                    class="fab fa-emoticon-outline"></i></a>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-dark waves-effect">Post</button>
                                    </div>
                                </form>
                            </div>
                            <div class="border border-dark rounded p-2 mb-3">

                            </div>

                            <div class="text-center">
                                <a href="javascript:void(0);" class="text-danger"><i
                                        class="fab fa-spin mdi-loading me-1"></i> Load more </a>
                            </div>

                        </div>
                        <div class="tab-pane" id="settings">
                            @include('profile.includes.profile-information')
                            @include('profile.includes.entreprise-information')
                            @include('profile.includes.update-password')
                            @include('profile.includes.delete-user')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- @push('styles')
        <style>
            :root {
                --transition-speed: 0.3s;
            }

            .profile-picture {
                width: 128px;
                height: 128px;
                border-radius: 50%;
                border: 4px solid white;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                position: relative;
                overflow: hidden;
                background-color: #e9ecef;
                cursor: pointer;
                transition: all var(--transition-speed);
            }

            .profile-picture:hover {
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            }

            .profile-picture:hover .profile-picture-overlay {
                opacity: 1;
            }

            .profile-picture-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity var(--transition-speed);
            }


            .autosave-indicator {
                font-size: 0.875rem;
                color: #6c757d;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .saving-spinner {
                width: 16px;
                height: 16px;
                border: 2px solid #dee2e6;
                border-top-color: #0d6efd;
                border-radius: 50%;
                animation: spin 0.6s linear infinite;
            }
        </style>
    @endpush --}}
    <div class="card bg-light bg-gradient p-4 mb-4 shadow">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="image-container rounded-pill shadow-lg">
                        <img src="{{ asset('assets/images/' . $user->image()) }}" alt="Image"
                            class="image-preview profile mx-auto d-block img-lg img-square" />
                        <label for="profile" class="image-overlay">
                            <i class="bi bi-camera-fill fs-3"></i>
                        </label>
                        <input type="file" id="profile" name="image" accept="image/*" class="image-input" />
                    </div>
                </div>
                <div class="col">
                    <h1 class="h3 mb-2">Paramètres du profil</h1>
                    <p class="mb-0 text-white-50">Gérez les paramètres et préférences de votre compte</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
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
                                            <textarea class="form-control editor" name="description" rows="5">
                                                {!! $user->description !!}
                                            </textarea>
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
                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab"
                        tabindex="0">
                        <div class="card border-0 shadow-sm mb-4 mt-4">
                            <div class="card-body p-4">
                                <div class="mt-4">
                                    <h5 class="mb-3">Sécurité & Connexion</h5>
                                    <div class="g-3">
                                        <div class="col-md-12">
                                            <label for="currentPassword" class="form-label">Mot de passe actuel</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="currentPassword">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    data-toggle-password="currentPassword">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="newPassword"
                                                    pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    data-toggle-password="newPassword">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="confirmPassword" class="form-label">Confirmer le nouveau mot de
                                                passe</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirmPassword">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    data-toggle-password="confirmPassword">
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
        <!-- Toast de succès -->
        {{-- <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i>
                    Modifications enregistrées avec succès !
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div> --}}

        {{-- <form>
            <!-- Informations de base -->
            <div class="card p-4 mb-4 border-0">
                <h2 class="h5 mb-4">Informations de base</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="firstName" name="prenom"
                            value="{{ old('prenom', $user->prenom) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="lastName" name="nom"
                            value="{{ old('nom', $user->nom) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Numéro de téléphone</label>
                        <input type="tel" class="form-control" id="phone" name="telephone"
                            value="{{ old('telephone', $user->telephone) }}" pattern="[\d\s\(\)\-\+]+" required>
                    </div>
                </div>
            </div>

            <!-- Adresse -->
            <div class="col-md-12">
                <label class="form-label">Adresse</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                    <input type="text" class="form-control" placeholder="Numéro de rue, nom de la rue" id="rue"
                        name="adresse[rue]" value="{{ old('adresse.rue', $user->adresse['rue']) }}">
                    <span class="input-group-text"><i class="bi bi-house-add"></i></span>
                    <input type="text" class="form-control" placeholder="Complément d'adresse (facultatif)"
                        id="complement" name="adresse[complement]"
                        value="{{ old('adresse.complement', $user->adresse['complement']) }}">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                    <input type="text" class="form-control" placeholder="Ville" id="ville" name="adresse[ville]"
                        value="{{ old('adresse.ville', $user->adresse['ville']) }}">
                    <span class="input-group-text"><i class="bi bi-mailbox"></i></span>
                    <input type="text" class="form-control" placeholder="Code Postal" id="code_postal"
                        name="adresse[code_postal]"
                        value="{{ old('adresse.code_postal', $user->adresse['code_postal']) }}">
                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                    <input type="text" class="form-control" placeholder="Pays" id="pays" name="adresse[pays]"
                        value="{{ old('adresse.pays', $user->adresse['pays']) }}">
                </div>
            </div>

            <!-- Modification du mot de passe -->
            <div class="card p-4 mb-4 border-0">
                <h2 class="h5 mb-4">Modifier le mot de passe</h2>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="currentPassword" class="form-label">Mot de passe actuel</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="currentPassword">
                            <button class="btn btn-outline-secondary" type="button"
                                data-toggle-password="currentPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword"
                                pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                            <button class="btn btn-outline-secondary" type="button" data-toggle-password="newPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="confirmPassword" class="form-label">Confirmer le nouveau mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword">
                            <button class="btn btn-outline-secondary" type="button"
                                data-toggle-password="confirmPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paramètres des notifications -->
            <div class="card p-4 mb-4 border-0">
                <h2 class="h5 mb-4">Préférences de notification</h2>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                    <label class="form-check-label" for="emailNotifications">Notifications par e-mail</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="smsNotifications">
                    <label class="form-check-label" for="smsNotifications">Notifications par SMS</label>
                </div>
            </div>

            <!-- Paramètres de confidentialité -->
            <div class="card p-4 mb-4 border-0">
                <h2 class="h5 mb-4">Paramètres de confidentialité</h2>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="profileVisibility" checked>
                    <label class="form-check-label" for="profileVisibility">
                        Rendre mon profil visible aux autres utilisateurs
                    </label>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="autosave-indicator">
                    <span class="saving-spinner d-none"></span>
                    <span class="autosave-text">Toutes les modifications sont enregistrées</span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteAccountModal">
                        Supprimer le compte
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form> --}}
    </div>


@endsection
