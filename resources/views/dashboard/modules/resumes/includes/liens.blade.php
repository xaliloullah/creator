<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3"><input type="text" name="parametre[lien]" class="form-control-plaintext m-0 text-dark"
                    value="{{ $resume->parametre['lien'] ?? 'Liens' }}"></h5>

            <div id="liens-container">
                @if ($resume->liens)
                    <div class="row p-3 sortable">
                        @foreach ($resume->liens as $index => $lien)
                            <div class="card shadow mb-3 col-12 lien-section">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="liens[{{ $index }}][nom]"
                                            class="form-control" placeholder="Nom du lien:"
                                            value="{{ $lien['nom'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="url" name="liens[{{ $index }}][url]"
                                            class="form-control" placeholder="URL du lien:"
                                            value="{{ $lien['url'] ?? '' }}" required>
                                    </div>
                                    @if (!$loop->first)
                                        <button type="button" class="btn btn-outline-danger btn-sm float-end"
                                            onclick="removeLien(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        Aucun lien.
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-success btn-sm mb-3 float-end" onclick="addLien()">
                <i class="bi bi-plus"></i> Ajouter
            </button>

            <script>
                let lienIndex = {{ count((array) $resume->liens) + 1 }};

                function addLien() {
                    const container = document.getElementById('liens-container');
                    const newSection = document.createElement('div');
                    newSection.className = 'card shadow mb-3 col-12 lien-section';
                    newSection.innerHTML = `
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="liens[\${lienIndex}][nom]" class="form-control"
                                            placeholder="Nom du lien:" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="url" name="liens[\${lienIndex}][url]" class="form-control"
                                            placeholder="URL du lien:" required>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm float-end" onclick="removeLien(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                    container.appendChild(newSection);
                    lienIndex++;
                }

                function removeLien(button) {
                    button.closest('.lien-section')?.remove();
                }
            </script>
        </div>
    </div>
</div>
