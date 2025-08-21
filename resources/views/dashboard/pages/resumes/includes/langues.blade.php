<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3"><input type="text" name="parametre[langue]" class="form-control-plaintext m-0 text-dark"
                    value="{{ $resume->parametre['langue'] ?? 'Langues' }}"></h5>

            <div id="langues-container">
                @if ($resume->langues)
                    <div class="row p-3 sortable">
                        @foreach ($resume->langues as $index => $langue)
                            <div class="card shadow mb-3 col-12 langue-section">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="text" name="langues[{{ $index }}][langue]"
                                                class="form-control" placeholder="Langue:"
                                                value="{{ $langue['langue'] ?? '' }}" required>
                                        </div>
                                        <div class="col-6">
                                            <input type="number" name="langues[{{ $index }}][niveau]"
                                                class="form-control" placeholder="Niveau (1 - 100):" min="1"
                                                max="100" value="{{ $langue['niveau'] ?? '' }}" required>
                                        </div>
                                    </div>
                                    @if (!$loop->first)
                                        <button type="button" class="btn btn-outline-danger btn-sm float-end mt-2"
                                            onclick="removeLangue(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        Aucune langue.
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-success btn-sm mb-3 float-end" onclick="addLangue()">
                <i class="bi bi-plus"></i> Ajouter
            </button>

            <script>
                let langueIndex = {{ count((array) $resume->langues) + 1 }};

                function addLangue() {
                    const container = document.getElementById('langues-container');
                    const newSection = document.createElement('div');
                    newSection.className = 'card shadow mb-3 col-12 langue-section';
                    newSection.innerHTML = `
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="text" name="langues[\${langueIndex}][langue]" class="form-control"
                                                placeholder="Langue:" required>
                                        </div>
                                        <div class="col-6">
                                            <input type="number" name="langues[\${langueIndex}][niveau]" class="form-control"
                                                placeholder="Niveau (1 - 100):" min="1" max="100" required>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm float-end mt-2" onclick="removeLangue(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                    container.appendChild(newSection);
                    langueIndex++;
                }

                function removeLangue(button) {
                    button.closest('.langue-section')?.remove();
                }
            </script>
        </div>
    </div>
</div>
