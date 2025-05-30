<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3"><input type="text" name="parametre[competence]"
                    class="form-control-plaintext m-0 text-dark"
                    value="{{ $resume->parametre['competence'] ?? 'Compétences' }}"></h5>
            <div id="competences-container">
                @if ($resume->competences)
                    <div class="row p-3 sortable">
                        @foreach ($resume->competences as $index => $competence)
                            <div class="card shadow mb-3 col-12 competence-section">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="competences[{{ $index }}][titre]"
                                            class="form-control" placeholder="Titre:" value="{{ $competence['titre'] }}"
                                            required>
                                    </div>
                                    <label class="form-label">Compétences:</label>
                                    <div class="mb-3">
                                        <select class="tags form-control" multiple
                                            name="competences[{{ $index }}][competence][]" required>
                                            @foreach ($competence['competence'] as $item)
                                                <option value="{{ $item }}" selected>{{ $item }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (!$loop->first)
                                        <button type="button" class="btn btn-outline-danger btn-sm float-end"
                                            onclick="removeCompetence(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        Aucune compétence.
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-success btn-sm mb-3 float-end" onclick="addCompetence()">
                <i class="bi bi-plus"></i> Ajouter
            </button>

            <script>
                let competenceIndex = {{ count((array) $resume->competences) + 1 }};

                function addCompetence() {
                    const container = document.getElementById('competences-container');
                    const newSection = document.createElement('div');
                    newSection.className = 'card shadow mb-3 col-12 competence-section';
                    newSection.innerHTML = `
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" name="competences[${competenceIndex}][titre]" class="form-control"
                        placeholder="Titre:" required>
                </div>
                <label class="form-label">Compétences:</label>
                <div class="mb-3">
                    <select class="tags form-control" multiple name="competences[${competenceIndex}][competence][]" required>
                    </select>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm float-end" onclick="removeCompetence(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
                    container.appendChild(newSection);

                    // Initialiser Tom Select sur le nouvel élément
                    new TomSelect(newSection.querySelector('.tags'), {
                        persist: false,
                        createOnBlur: true,
                        create: true,
                        plugins: ["remove_button"],
                    });

                    competenceIndex++;
                }

                function removeCompetence(button) {
                    button.closest('.competence-section')?.remove();
                }
            </script>
        </div>
    </div>
</div>
