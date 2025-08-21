<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3"><input type="text" name="parametre[reseaux_sociaux]"
                    class="form-control-plaintext m-0 text-dark"
                    value="{{ $resume->parametre['reseaux_sociaux'] ?? 'Réseaux Sociaux' }}"></h5>
            <div id="reseaux_sociaux-container" class="col-12 row g-3 sortable">
                @forelse ($resume->reseaux_sociaux as $index => $reseaux_sociaux)
                    <div class="card shadow col-12 reseaux_sociaux-section">
                        <div class="card-body">
                            <div class="form-group row g-1">
                                <div class="input-group">
                                    <input type="text" name="reseaux_sociaux[{{ $index }}][name]"
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
                                    <input type="url" name="reseaux_sociaux[{{ $index }}][url]"
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
                    <a class="btn btn-dark mb-1" onclick="addReseauxSociaux(this)" data-icon="{{ $icon }}"
                        title="{{ ucfirst($icon) }}">
                        <i class="bi bi-{{ $icon }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    let reseaux_sociauxIndex = {{ count((array) $resume->reseaux_sociaux) + 1 }};

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
