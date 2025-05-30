<div id="reseaux_sociaux-container">
    @if (is_array($reseaux_sociauxs = json_decode($resume->reseaux_sociaux, true)))
        <div class="row p-3 sortable">
            @foreach (json_decode($resume->reseaux_sociaux, true) ?? [] as $index => $reseaux_sociaux)
                <div class="card shadow border-left-primary col-12 reseaux_sociaux-section">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="reseaux_sociaux[{{ $index }}][name]" class="form-control"
                                placeholder="name:" value="{{ $reseaux_sociaux['name'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="reseaux_sociaux[{{ $index }}][icon]" class="form-control"
                                placeholder="icon:" value="{{ $reseaux_sociaux['icon'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text"><i
                                        class="fab fa-{{ $reseaux_sociaux['icon'] ?? '' }}"></i></span>
                                <input type="url" name="reseaux_sociaux[{{ $index }}][url]"
                                    class="form-control" placeholder="url:" value="{{ $reseaux_sociaux['url'] ?? '' }}"
                                    required>
                            </div>
                        </div>
                        @if (!$loop->first)
                            <a href="#!" class="float-right btn btn-sm btn-danger"
                                onclick="removeReseaux_sociaux(this)"><i class="fa fa-trash"></i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            Aucun reseaux sociaux.
        </div>
    @endif
    <script>
        let reseaux_sociauxIndex =
            {{ is_array($reseaux_sociaux = json_decode($resume->reseaux_sociaux)) ? count($reseaux_sociaux) : (is_object($reseaux_sociaux) ? count((array) $reseaux_sociaux) : 0) }};

        function addReseaux_sociaux(icon) {
            const container = document.getElementById('reseaux_sociaux-container');
            const newSection = document.createElement('div');
            newSection.className = 'card shadow border-left-primary col-12 reseaux_sociaux-section';
            newSection.innerHTML = `
            <div class="card-body">
                <div class="form-group">
                    <input type="text" name="reseaux_sociaux[${reseaux_sociauxIndex}][name]" class="form-control" placeholder="name:" value="${icon}" required>
                </div>
                 <div class="form-group">
                    <input type="hidden" name="reseaux_sociaux[${reseaux_sociauxIndex}][icon]" class="form-control" value="${icon}"
                        placeholder="icon:" required>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-${ icon}"></i></span>
                        <input type="url" name="reseaux_sociaux[${reseaux_sociauxIndex}][url]" class="form-control" placeholder="url:" required>
                    </div>
                </div>
                <a href="#!" class="float-right btn btn-sm btn-danger" onclick="removeReseaux_sociaux(this)"><i
                        class="fa fa-trash"></i></a>
            </div>
        `;
            container.appendChild(newSection);

            reseaux_sociauxIndex++;
        }

        function removeReseaux_sociaux(button) {
            const section = button.closest('.reseaux_sociaux-section');
            if (section) {
                section.remove();
            }
        }
    </script>
</div>
<div class="text-center">
    @foreach ($icons = ['facebook', 'linkedin', 'github', 'twitter', 'tiktok', 'youtube', 'google', 'discord', 'instagram', 'whatsapp', 'telegram', 'snapchat','twitch','tumblr','skype','pinterest'] as $icon)
        <a href="#" class="btn btn-dark btn-circle mr-1 mb-1" onclick="addReseaux_sociaux('{{ $icon }}')"
            title="{{ $icon }}">
            <i class="fab fa-{{ $icon }}"></i>
        </a>
    @endforeach
</div>
