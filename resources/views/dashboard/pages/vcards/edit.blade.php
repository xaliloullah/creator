@extends('dashboard.index')
@section('title', 'vcards')
@section('subtitle', 'Modifier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un vcard</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations du vcard en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>

        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('vcards.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('vcards.show', $vcard->id) }}" class="btn btn-outline-dark" target="_blank">
                <i class="bi bi-eye"></i><span class="d-none d-sm-inline ms-2">Consulter</span>
            </a>
            <a href="{{ route('vcards.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('vcards.update', $vcard->id) }}" method="POST" enctype="multipart/form-data" class="validate">
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
                                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="prenom" name="prenom"
                                        value="{{ old('prenom', $vcard->prenom) }}" placeholder="Prénom" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nom </label>
                                    <input type="text" class="form-control" id="nom" name="nom"
                                        value="{{ old('nom', $vcard->nom) }}" placeholder="Nom" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="email" value="{{ old('email', $vcard->email) }}" />
                                        <span class="input-group-text">@</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre"
                                        placeholder="Titre" value="{{ old('titre', $vcard->titre) }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Organisation</label>
                                    <input type="text" class="form-control" id="organisation" name="organisation"
                                        placeholder="Organisation"
                                        value="{{ old('organisation', $vcard->organisation) }}" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Telephones</label>
                                    <select class="form-control tags" multiple name="telephones[]">
                                        @foreach ($vcard->telephones as $telephone)
                                            <option value="{{ $telephone }}" selected>{{ $telephone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Adresse</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        <input type="text" class="form-control"
                                            placeholder="Numéro de rue, nom de la rue" id="rue" name="adresse[rue]"
                                            value="{{ old('adresse.rue', $vcard->adresse['rue']) }}">
                                        <span class="input-group-text"><i class="bi bi-house-add"></i></span>
                                        <input type="text" class="form-control"
                                            placeholder="Complément d'adresse (facultatif)" id="complement"
                                            name="adresse[complement]"
                                            value="{{ old('adresse.complement', $vcard->adresse['complement']) }}">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                        <input type="text" class="form-control" placeholder="Ville" id="ville"
                                            name="adresse[ville]"
                                            value="{{ old('adresse.ville', $vcard->adresse['ville']) }}">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="text" class="form-control" placeholder="Code Postal"
                                            id="code_postal" name="adresse[code_postal]"
                                            value="{{ old('adresse.code_postal', $vcard->adresse['code_postal']) }}">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="text" class="form-control" placeholder="Pays" id="pays"
                                            name="adresse[pays]"
                                            value="{{ old('adresse.pays', $vcard->adresse['pays']) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <h5 class="mb-3">Styles</h5>
                            <div class="col-md-6">
                                <label class="form-label" for="parametre[primary]">Couleur Primaire</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0"
                                        value="{{ old('parametre.primary', $vcard->parametre['primary'] ?? '#4e73df') }}"
                                        id="parametre[primary]" name="parametre[primary]"
                                        title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #4e73df" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="parametre[secondary]">Couleur Secondaire</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0"
                                        value="{{ old('parametre.secondary', $vcard->parametre['secondary'] ?? '#858796') }}"
                                        id="parametre[secondary]" name="parametre[secondary]"
                                        title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #858796" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="parametre[background]">Couleur Arrière plan</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0"
                                        value="{{ old('parametre.background', $vcard->parametre['background'] ?? '#f8f9fc') }}"
                                        id="parametre[background]" name="parametre[background]"
                                        title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #f8f9fc" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="parametre[foreground]">Couleur Premier plan</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0"
                                        value="{{ old('parametre.foreground', $vcard->parametre['foreground'] ?? '#ffffff') }}"
                                        id="parametre[foreground]" name="parametre[foreground]"
                                        title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #ffffff" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5 class="mb-3">Image</h5>
                                <div class="text-center mb-3">
                                    <div class="image-container rounded-circle img-lg shadow">
                                        <img src="{{ asset('assets/images/' . $vcard->image()) }}" alt="image"
                                            class="image-preview img-square image mx-auto d-block" />
                                        <label for="image" class="image-overlay">
                                            <i class="bi bi-camera-fill fs-3"></i>
                                        </label>
                                        <input type="file" id="image" accept="image/*" class="image-input"
                                            name="image" />
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
                                                @if (old('statut', $vcard->statut->value) == $statut->value) checked @endif required />
                                            <label class="form-check-label badge bg-{{ $statut->color }}"
                                                for="statut-{{ $statut->value }}">{{ $statut->name }}</label>
                                        </div>
                                    @endforeach 
                                </div> --}}
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control editor" id="description" name="description" placeholder="Description">{{ $vcard->description }}</textarea>
                                </div>
                                {{-- <div class="col-12">
                                    <label class="form-label">Condition</label>
                                    <select class="form-control tags" multiple name="condition[]">
                                        @foreach (json_decode($vcard->condition, true) ?? [] as $tag)
                                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                {{-- <div class="col-12">
                                    <label class="form-label">Tags</label>
                                    <select class="form-control tags" multiple name="tags[]">
                                        @foreach ($vcard->tags as $tag)
                                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-md-12">
                                    <label class="form-label">Site Web</label>
                                    <select class="form-control tags" multiple name="site_web[]">
                                        @foreach ($vcard->site_web as $site_web)
                                            <option value="{{ $site_web }}" selected>{{ $site_web }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Réseaux Sociaux</h5>
                            <div id="reseaux_sociaux-container" class="col-12 row g-3 sortable">
                                @forelse ($vcard->reseaux_sociaux as $index => $reseaux_sociaux)
                                    <div class="card shadow col-12 reseaux_sociaux-section">
                                        <div class="card-body">
                                            <div class="form-group row g-1">
                                                <div class="input-group">
                                                    <input type="text"
                                                        name="reseaux_sociaux[{{ $index }}][name]"
                                                        class="form-control" placeholder="Nom du réseau"
                                                        value="{{ $reseaux_sociaux['name'] ?? '' }}" required>
                                                    @if (!$loop->first)
                                                        <a class="btn btn-danger" onclick="removeReseauxSociaux(this)">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    @endif
                                                </div>

                                                <input type="hidden" name="reseaux_sociaux[{{ $index }}][icon]"
                                                    value="{{ $reseaux_sociaux['icon'] ?? '' }}" required>

                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-{{ $reseaux_sociaux['icon'] ?? '' }}"></i>
                                                    </span>
                                                    <input type="url"
                                                        name="reseaux_sociaux[{{ $index }}][url]"
                                                        class="form-control" placeholder="URL du profil"
                                                        value="{{ $reseaux_sociaux['url'] ?? '' }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning">
                                        Aucun réseau social ajouté.
                                    </div>
                                @endforelse
                            </div>

                            <div class="text-center mt-3">
                                @php
                                    $icons = [
                                        'discord',
                                        'facebook',
                                        'github',
                                        'google',
                                        'instagram',
                                        'linkedin',
                                        'messenger',
                                        'pinterest',
                                        'reddit',
                                        'skype',
                                        'snapchat',
                                        'spotify',
                                        'telegram',
                                        'tiktok',
                                        'twitch',
                                        'twitter-x',
                                        'whatsapp',
                                        'youtube',
                                    ];
                                @endphp
                                @foreach ($icons as $icon)
                                    <a class="btn btn-dark mb-1" onclick="addReseauxSociaux(this)"
                                        data-icon="{{ $icon }}" title="{{ ucfirst($icon) }}">
                                        <i class="bi bi-{{ $icon }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    let reseaux_sociauxIndex = {{ count((array) $vcard->reseaux_sociaux) + 1 }};

                    function addReseauxSociaux(button) {
                        const icon = button.dataset.icon;
                        const container = document.getElementById('reseaux_sociaux-container');
                        const newSection = document.createElement('div');
                        newSection.className = 'card shadow col-12 reseaux_sociaux-section';
                        newSection.innerHTML = `
                            <div class="card-body">
                                <div class="form-group row g-1">
                                    <div class="input-group">
                                        <input type="text" name="reseaux_sociaux[${reseaux_sociauxIndex}][name]" class="form-control" placeholder="Nom du réseau" value="${icon}" required>
                                        <a class="btn btn-danger" onclick="removeReseauxSociaux(this)">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </div>
                                    <input type="hidden" name="reseaux_sociaux[${reseaux_sociauxIndex}][icon]" value="${icon}" required>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-${icon}"></i>
                                        </span>
                                        <input type="url" name="reseaux_sociaux[${reseaux_sociauxIndex}][url]" class="form-control" placeholder="URL du profil" required>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.appendChild(newSection);
                        reseaux_sociauxIndex++;
                    }

                    function removeReseauxSociaux(button) {
                        const section = button.closest('.reseaux_sociaux-section');
                        if (section) {
                            section.remove();
                        }
                    }
                </script>

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
            <div class="col-lg-4 d-none d-sm-block">
                <div class="card shadow-lg sticky-top overflow-hidden rounded-4 mobile-size">
                    <div class="card-header text-center shadow">Aperçu</div>
                    <iframe src="{{ route('vcards.show', $vcard->id) }}" class="w-100 h-100 border-0"></iframe>
                </div>

                {{-- <div class="card card-ghost shadow-lg">
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
                </div> --}}
            </div>
        </div>
    </form>
@endsection
