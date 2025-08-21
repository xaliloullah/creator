@extends('dashboard.index')
@section('title', 'restos')
@section('title2', 'Modifier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un resto</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations du resto en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>

        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('restos.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('restos.show', $resto->id) }}" class="btn btn-outline-dark" target="_blank">
                <i class="bi bi-eye"></i><span class="d-none d-sm-inline ms-2">Consulter</span>
            </a>
            <a href="{{ route('restos.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('restos.update', $resto->id) }}" method="POST" enctype="multipart/form-data"
        class="validate">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-info-tab" data-bs-toggle="tab"
                            data-bs-target="#general-info" type="button" role="tab" aria-controls="general-info"
                            aria-selected="true">Informations
                            générales</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories"
                            type="button" role="tab" aria-controls="categories"
                            aria-selected="true">Categories</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="produits-tab" data-bs-toggle="tab" data-bs-target="#produits"
                            type="button" role="tab" aria-controls="produits" aria-selected="true">Produits</button>
                    </li>
                </ul>
                <div class="tab-content" id="components-content">
                    <div class="tab-pane fade show active" id="general-info" role="tabpanel"
                        aria-labelledby="general-info-tab" tabindex="0">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <h5 class="mb-3">Informations générales</h5>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <div class="text-center mb-3">
                                                <h5 class="mb-3">Image</h5>
                                                <div class="image-container rounded-circle img-lg shadow">
                                                    <img src="{{ asset('assets/images/' . $resto->image()) }}"
                                                        alt="image"
                                                        class="image-preview img-square image mx-auto d-block" />
                                                    <label for="image" class="image-overlay">
                                                        <i class="bi bi-camera-fill fs-3"></i>
                                                    </label>
                                                    <input type="file" id="image" accept="image/*"
                                                        class="image-input" name="image" />
                                                </div>
                                                {{-- <div class="d-grid">
                                                    <label for="image" class="btn btn-outline-dark">
                                                        <i class="bi bi-upload"></i><span class="ms-2">Télécharger une
                                                            image</span>
                                                    </label>
                                                </div> --}}
                                                <small class="text-muted d-block text-center mt-2">Maximum file size:
                                                    2MB</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Désignation <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="designation" name="designation"
                                                value="{{ old('designation', $resto->designation) }}"
                                                placeholder="Désignation" required />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Type de resto </label>
                                            <input type="text" class="form-control" id="type" name="type"
                                                value="{{ old('type', $resto->type) }}" placeholder="type" />
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <div class="input-group">
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="email" value="{{ old('email', $resto->email) }}" />
                                                <span class="input-group-text">@</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Telephones</label>
                                            <select class="form-select tags" multiple name="telephones[]">
                                                @foreach ($resto->telephones as $telephone)
                                                    <option value="{{ $telephone }}" selected>{{ $telephone }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}
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
                                                value="{{ old('parametre.primary', $resto->parametre['primary'] ?? '#4e73df') }}"
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
                                                value="{{ old('parametre.secondary', $resto->parametre['secondary'] ?? '#858796') }}"
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
                                                value="{{ old('parametre.background', $resto->parametre['background'] ?? '#f8f9fc') }}"
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
                                                value="{{ old('parametre.foreground', $resto->parametre['foreground'] ?? '#ffffff') }}"
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
                                            {{-- @foreach ($statuts as $statut)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="statut"
                                                        id="statut-{{ $statut->value }}" value="{{ $statut->value }}"
                                                        @if (old('statut', $resto->statut->value) == $statut->value) checked @endif required />
                                                    <label class="form-check-label badge bg-{{ $statut->color }}"
                                                        for="statut-{{ $statut->value }}">{{ $statut->name }}</label>
                                                </div>
                                            @endforeach --}}
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control editor" id="description" name="description" placeholder="Description">{{ $resto->description }}</textarea>
                                        </div>
                                        {{-- <div class="col-12">
                                            <label class="form-label">Condition</label>
                                            <select class="form-select tags" multiple name="condition[]">
                                                @foreach (json_decode($resto->condition, true) ?? [] as $tag)
                                                    <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <div class="col-12">
                                            <label class="form-label">Tags</label>
                                            <select class="form-select tags" multiple name="tags[]">
                                                @foreach ($resto->tags as $tag)
                                                    <option value="{{ $tag }}" selected>{{ $tag }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Site Web</label>
                                            <select class="form-select tags" multiple name="site_web[]">
                                                @foreach ($resto->site_web as $site_web)
                                                    <option value="{{ $site_web }}" selected>{{ $site_web }}
                                                    </option>
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
                                        @forelse ($resto->reseaux_sociaux as $index => $reseaux_sociaux)
                                            <div class="card shadow col-12 reseaux_sociaux-section">
                                                <div class="card-body">
                                                    <div class="form-group row g-1">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                name="reseaux_sociaux[{{ $index }}][name]"
                                                                class="form-control" placeholder="Nom du réseau"
                                                                value="{{ $reseaux_sociaux['name'] ?? '' }}" required>
                                                            @if (!$loop->first)
                                                                <a class="btn btn-danger"
                                                                    onclick="removeReseauxSociaux(this)">
                                                                    <i class="bi bi-x-lg"></i>
                                                                </a>
                                                            @endif
                                                        </div>

                                                        <input type="hidden"
                                                            name="reseaux_sociaux[{{ $index }}][icon]"
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
                    </div>
                    <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab"
                        tabindex="0">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                {{--  --}}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="produits" role="tabpanel" aria-labelledby="produits-tab"
                        tabindex="0">
                        {{--  --}}
                    </div>
                    {{-- <div class="card card-ghost shadow-lg sticky-bottom">
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
                    </div> --}}
                </div>

                {{-- cici --}}



                <script>
                    let reseaux_sociauxIndex = {{ count((array) $resto->reseaux_sociaux) + 1 }};

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
                <div class="card shadow-lg sticky-top overflow-hidden rounded-4 h-25">
                    <div class="card-header shadow">Aperçu</div>
                    <iframe src="{{ route('restos.show', $resto->id) }}" class="w-100 h-100 border-0"></iframe>
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
