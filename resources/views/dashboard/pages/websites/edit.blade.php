@extends('dashboard.index')
@section('title', 'Websites')
@section('subtitle', 'Modifier')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un Website</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations du Website en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('websites.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('websites.show', $website->id) }}" class="btn btn-outline-dark" target="_blank">
                <i class="bi bi-eye"></i><span class="d-none d-sm-inline ms-2">Consulter</span>
            </a>
            <a href="{{ route('websites.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <form action="{{ route('websites.update', $website->id) }}" method="POST" enctype="multipart/form-data"
        class="validate">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">

                {{-- Informations générales --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Informations générales</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Désignation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="designation"
                                    value="{{ old('designation', $website->designation) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="slug"
                                    value="{{ old('slug', $website->slug) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Thème</label>
                                <input type="text" class="form-control" name="theme"
                                    value="{{ old('theme', $website->theme) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type</label>
                                <input type="text" class="form-control" name="type"
                                    value="{{ old('type', $website->type) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Logo</label>
                                <input type="file" class="form-control" name="logo" accept="image/*">
                                @if ($website->logo)
                                    <img src="{{ asset('storage/' . $website->logo) }}" class="img-thumbnail mt-2"
                                        style="max-height:80px;">
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Favicon</label>
                                <input type="file" class="form-control" name="favicon" accept="image/*">
                                @if ($website->favicon)
                                    <img src="{{ asset('storage/' . $website->favicon) }}" class="img-thumbnail mt-2"
                                        style="max-height:40px;">
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control editor" name="description">{{ old('description', $website->description) }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Contact</label>
                                <textarea class="form-control" name="contact">{{ old('contact', $website->contact) }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Adresse</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Rue" name="adresse[rue]"
                                        value="{{ old('adresse.rue', $website->adresse['rue'] ?? '') }}">
                                    <input type="text" class="form-control" placeholder="Complément"
                                        name="adresse[complement]"
                                        value="{{ old('adresse.complement', $website->adresse['complement'] ?? '') }}">
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Ville" name="adresse[ville]"
                                        value="{{ old('adresse.ville', $website->adresse['ville'] ?? '') }}">
                                    <input type="text" class="form-control" placeholder="Code Postal"
                                        name="adresse[code_postal]"
                                        value="{{ old('adresse.code_postal', $website->adresse['code_postal'] ?? '') }}">
                                    <input type="text" class="form-control" placeholder="Pays" name="adresse[pays]"
                                        value="{{ old('adresse.pays', $website->adresse['pays'] ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Téléphones</label>
                                <select class="form-control tags" multiple name="telephones[]">
                                    @foreach ($website->telephones ?? [] as $tel)
                                        <option value="{{ $tel }}" selected>{{ $tel }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Styles --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Styles</h5>
                        @php
                            $params = $website->parametre ?? [];
                            $colors = ['primary', 'secondary', 'background', 'foreground'];
                        @endphp
                        <div class="row g-3">
                            @foreach ($colors as $color)
                                <div class="col-md-6">
                                    <label class="form-label">{{ ucfirst($color) }}</label>
                                    <div class="input-group color-picker mb-4">
                                        <input type="color" class="color-input color-option shadow border-0"
                                            name="parametre[{{ $color }}]"
                                            value="{{ old('parametre.' . $color, $params[$color] ?? '#ffffff') }}">
                                        <input type="text" class="color-code form-control form-control-sm"
                                            placeholder="{{ $params[$color] ?? '#ffffff' }}">
                                        <button type="button" class="color-option color-random btn btn-dark">
                                            <i class="bi bi-shuffle"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Réseaux sociaux --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Réseaux Sociaux</h5>
                        <div id="reseaux_sociaux-container" class="col-12 row g-3 sortable">
                            @forelse($website->reseaux_sociaux ?? [] as $index => $rs)
                                <div class="card shadow col-12 reseaux_sociaux-section">
                                    <div class="card-body">
                                        <div class="form-group row g-1">
                                            <div class="input-group">
                                                <input type="text" name="reseaux_sociaux[{{ $index }}][name]"
                                                    class="form-control" placeholder="Nom du réseau"
                                                    value="{{ $rs['name'] ?? '' }}" required>
                                                @if (!$loop->first)
                                                    <a class="btn btn-danger" onclick="removeReseauxSociaux(this)">
                                                        <i class="bi bi-x-lg"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <input type="hidden" name="reseaux_sociaux[{{ $index }}][icon]"
                                                value="{{ $rs['icon'] ?? '' }}" required>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="bi bi-{{ $rs['icon'] ?? '' }}"></i></span>
                                                <input type="url" name="reseaux_sociaux[{{ $index }}][url]"
                                                    class="form-control" placeholder="URL du profil"
                                                    value="{{ $rs['url'] ?? '' }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning">Aucun réseau social ajouté.</div>
                            @endforelse
                        </div>

                        <div class="text-center mt-3">
                            @php
                                $icons = [
                                    'facebook',
                                    'twitter-x',
                                    'instagram',
                                    'linkedin',
                                    'youtube',
                                    'github',
                                    'whatsapp',
                                    'telegram',
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

                {{-- Submit buttons --}}
                <div class="card card-ghost shadow-lg sticky-bottom">
                    <div class="card-body p-3">
                        <div class="d-flex gap-2 float-end">
                            <button type="reset" class="btn btn-outline-danger"><i
                                    class="bi bi-x-circle me-1"></i>Annuler</button>
                            <button type="submit" class="btn btn-primary"><i
                                    class="bi bi-pencil-square me-1"></i>Modifier</button>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Aperçu côté droit --}}
            <div class="col-lg-4 d-none d-sm-block">
                <div class="card shadow-lg sticky-top overflow-hidden rounded-4 mobile-size">
                    <div class="card-header text-center shadow">Aperçu</div>
                    <iframe src="{{ route('websites.show', $website->id) }}" class="w-100 h-100 border-0"></iframe>
                </div>
            </div>

        </div>
    </form>

    @push('scripts')
        <script>
            let reseaux_sociauxIndex = {{ count($website->reseaux_sociaux ?? []) + 1 }};

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
                    <a class="btn btn-danger" onclick="removeReseauxSociaux(this)"><i class="bi bi-x-lg"></i></a>
                </div>
                <input type="hidden" name="reseaux_sociaux[${reseaux_sociauxIndex}][icon]" value="${icon}" required>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-${icon}"></i></span>
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
                if (section) section.remove();
            }
        </script>
    @endpush

@endsection
