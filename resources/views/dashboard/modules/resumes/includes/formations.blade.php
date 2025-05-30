<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3"><input type="text" name="parametre[formation]"
                    class="form-control-plaintext m-0 text-dark"
                    value="{{ $resume->parametre['formation'] ?? 'Formations' }}"></h5>

            <div id="formations-container">
                @if ($resume->formations)
                    <div class="row p-3 sortable">
                        @foreach ($resume->formations as $index => $formation)
                            <div class="card shadow mb-3 col-12 formation-section">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="formations[{{ $index }}][diplome]"
                                            class="form-control" placeholder="Diplôme:"
                                            value="{{ $formation['diplome'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="formations[{{ $index }}][etablissement]"
                                            class="form-control" placeholder="Établissement:"
                                            value="{{ $formation['etablissement'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="formations[{{ $index }}][dates]"
                                            class="form-control" placeholder="Dates:"
                                            value="{{ $formation['dates'] ?? '' }}" required>
                                    </div>
                                    @if (!$loop->first)
                                        <button type="button" class="btn btn-outline-danger btn-sm float-end"
                                            onclick="removeFormation(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        Aucune formation.
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-success btn-sm mb-3 float-end" onclick="addFormation()">
                <i class="bi bi-plus"></i> Ajouter
            </button>

            <script>
                let formationIndex = {{ count((array) $resume->formations) + 1 }};

                function addFormation() {
                    const container = document.getElementById('formations-container');
                    const newSection = document.createElement('div');
                    newSection.className = 'card shadow mb-3 col-12 formation-section';
                    newSection.innerHTML = `
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="formations[\${formationIndex}][diplome]" class="form-control"
                                            placeholder="Diplôme:" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="formations[\${formationIndex}][etablissement]" class="form-control"
                                            placeholder="Établissement:" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="formations[\${formationIndex}][dates]" class="form-control"
                                            placeholder="Dates:" required>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm float-end" onclick="removeFormation(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                    container.appendChild(newSection);
                    formationIndex++;
                }

                function removeFormation(button) {
                    button.closest('.formation-section')?.remove();
                }
            </script>
        </div>
    </div>
</div>
