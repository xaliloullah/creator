@extends('dashboard.index')
@section('title', 'qrcodes')
@section('subtitle', 'Modifier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un qrcode</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations du qrcode en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>

        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('qrcodes.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('qrcodes.show', $qrcode->id) }}" class="btn btn-outline-dark" target="_blank">
                <i class="bi bi-eye"></i><span class="d-none d-sm-inline ms-2">Consulter</span>
            </a>
            <a href="{{ route('qrcodes.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('qrcodes.update', $qrcode->id) }}" method="POST" enctype="multipart/form-data" class="validate">
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
                                    <label class="form-label">Contenu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="content" name="content"
                                        placeholder="Contenu" value="{{ old('content', $qrcode->content ?? '') }}"
                                        required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Type</label>
                                    <input type="text" class="form-control" id="type" name="type"
                                        placeholder="Type" value="{{ old('type', $qrcode->type ?? '') }}" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="parametre[size]">Taille</label>
                                    <input type="number" class="form-control" id="parametre[size]" name="parametre[size]"
                                        value="{{ old('parametre.size', $qrcode->parametre['size'] ?? 100) }}"
                                        min="50" max="1000">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="parametre[style]">Forme</label>
                                    <select class="form-select" id="parametre[style]" name="parametre[style]">
                                        @foreach (['square', 'round', 'dot'] as $style)
                                            <option value="{{ $style }}" @selected(old('parametre.style', $qrcode->parametre['style'] ?? 'square') === $style)>
                                                {{ ucfirst($style) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="parametre[eye]">Style Eye</label>
                                    <select class="form-select" id="parametre[eye]" name="parametre[eye]">
                                        @foreach (['square', 'circle'] as $eye)
                                            <option value="{{ $eye }}" @selected(old('parametre.eye', $qrcode->parametre['eye'] ?? 'square') === $eye)>
                                                {{ ucfirst($eye) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="parametre[error_correction_level]">Niveau Correction
                                        Erreur</label>
                                    <select class="form-select" id="parametre[error_correction_level]"
                                        name="parametre[error_correction_level]">
                                        @foreach (['L', 'M', 'Q', 'H'] as $level)
                                            <option value="{{ $level }}" @selected(old('parametre.error_correction_level', $qrcode->parametre['error_correction_level'] ?? 'H') === $level)>
                                                {{ $level }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="parametre[gradient]">Direction du Gradient</label>
                                    <select class="form-select" id="parametre[gradient]" name="parametre[gradient]">
                                        @foreach (['vertical', 'horizontal', 'diagonal'] as $dir)
                                            <option value="{{ $dir }}" @selected(old('parametre.gradient', $qrcode->parametre['gradient'] ?? 'vertical') === $dir)>
                                                {{ ucfirst($dir) }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="col-md-6">
                                    <label class="form-label" for="parametre[margin]">Marge</label>
                                    <input type="number" class="form-control" id="parametre[margin]"
                                        name="parametre[margin]"
                                        value="{{ old('parametre.margin', $qrcode->parametre['margin'] ?? 3) }}"
                                        min="0" max="100">
                                </div>

                                {{-- <div class="col-md-6">
                                    <label class="form-label" for="parametre[eye-color]">Couleur Eye</label>
                                    <input type="color" class="form-control" id="parametre[eye-color]"
                                        name="parametre[eye-color]"
                                        value="{{ old('parametre.eye-color', $qrcode->parametre['eye-color'] ?? '#000000') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="parametre[background-eye-color]">Couleur Fond
                                        Eye</label>
                                    <input type="color" class="form-control" id="parametre[background-eye-color]"
                                        name="parametre[background-eye-color]"
                                        value="{{ old('parametre.background-eye-color', $qrcode->parametre['background-eye-color'] ?? '#ffffff') }}">
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
                                    <input type="color" class="color-option color-input shadow border-0"
                                        value="{{ old('parametre.primary', $qrcode->parametre['primary'] ?? '#4e73df') }}"
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
                                    <input type="color" class="color-option color-input shadow border-0"
                                        value="{{ old('parametre.secondary', $qrcode->parametre['secondary'] ?? '#858796') }}"
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
                            <div class="col-md-12">
                                <label class="form-label" for="parametre[background]">Couleur Arrière plan</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-option color-input shadow border-0"
                                        value="{{ old('parametre.background', $qrcode->parametre['background'] ?? '#ffffff') }}"
                                        id="parametre[background]" name="parametre[background]"
                                        title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #ffffff" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <label class="form-label" for="parametre[eye-color]">Couleur Eye</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-option color-input shadow border-0"
                                        value="{{ old('parametre.eye-color', $qrcode->parametre['eye-color'] ?? '#000000') }}"
                                        id="parametre[eye-color]" name="parametre[eye-color]"
                                        title="Choisissez votre couleur" />
                                    <input type="text" class="color-code form-control form-control-sm"
                                        placeholder="e.g. #000000" />
                                    <button type="button" class="color-option color-random btn btn-dark"
                                        title="Choisissez une couleur aléatoire">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <h5 class="mb-3">Image</h5>
                                {{-- <div class="text-center mb-3">
                                    <div class="image-container rounded-circle img-lg shadow">
                                        <img src="{{ asset('assets/images/' . $qrcode->image()) }}" alt="image"
                                            class="image-preview img-square image mx-auto d-block" />
                                        <label for="image" class="image-overlay">
                                            <i class="bi bi-camera-fill fs-3"></i>
                                        </label>
                                        <input type="file" id="image" accept="image/*" class="image-input"
                                            name="image" />
                                    </div>
                                </div> --}}
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
                                                @if (old('statut', $qrcode->statut->value) == $statut->value) checked @endif required />
                                            <label class="form-check-label badge bg-{{ $statut->color }}"
                                                for="statut-{{ $statut->value }}">{{ $statut->name }}</label>
                                        </div>
                                    @endforeach 
                                </div> --}}
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control editor" id="description" name="description" placeholder="Description">{{ $qrcode->description }}</textarea>
                                </div>
                                {{-- <div class="col-12">
                                    <label class="form-label">Condition</label>
                                    <select class="form-control tags" multiple name="condition[]">
                                        @foreach (json_decode($qrcode->condition, true) ?? [] as $tag)
                                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                {{-- <div class="col-12">
                                    <label class="form-label">Tags</label>
                                    <select class="form-control tags" multiple name="tags[]">
                                        @foreach ($qrcode->tags as $tag)
                                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                {{-- <div class="col-md-12">
                                    <label class="form-label">Site Web</label>
                                    <select class="form-control tags" multiple name="site_web[]">
                                        @foreach ($qrcode->site_web as $site_web)
                                            <option value="{{ $site_web }}" selected>{{ $site_web }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Réseaux Sociaux</h5>
                            {{-- <div id="reseaux_sociaux-container" class="col-12 row g-3 sortable">
                                @forelse ($qrcode->reseaux_sociaux as $index => $reseaux_sociaux)
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
                            </div> --}}

                            {{-- <div class="text-center mt-3">
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
                            </div> --}}
                        </div>
                    </div>
                </div>

                {{-- <script>
                    let reseaux_sociauxIndex = {{ count((array) $qrcode->reseaux_sociaux) + 1 }};

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
                </script> --}}

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
                    <iframe src="{{ route('qrcodes.show', $qrcode->id) }}" class="w-100 h-100 border-0"></iframe>
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
