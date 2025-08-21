<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3"><input type="text" name="parametre[experience]"
                    class="form-control-plaintext m-0 text-dark"
                    value="{{ $resume->parametre['experience'] ?? 'Expérience Professionnelle' }}"></h5>

            <div id="experiences-container">
                @if ($resume->experiences)
                    <div class="row p-3 sortable">
                        @foreach ($resume->experiences as $index => $experience)
                            <div class="card shadow mb-3 col-12 experience-section">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="experiences[{{ $index }}][poste]"
                                            class="form-control" placeholder="Poste:"
                                            value="{{ $experience['poste'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="experiences[{{ $index }}][entreprise]"
                                            class="form-control" placeholder="Entreprise:"
                                            value="{{ $experience['entreprise'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="experiences[{{ $index }}][dates]"
                                            class="form-control" placeholder="Dates:"
                                            value="{{ $experience['dates'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="experiences[{{ $index }}][description]" class="form-control" placeholder="Description:"
                                            rows="3" required>{{ $experience['description'] ?? '' }}</textarea>
                                    </div>
                                    @if (!$loop->first)
                                        <button type="button" class="btn btn-outline-danger btn-sm float-end"
                                            onclick="removeExperience(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        Aucune expérience.
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-success btn-sm mb-3 float-end" onclick="addExperience()">
                <i class="bi bi-plus"></i> Ajouter
            </button>

            <script>
                let experienceIndex = {{ count((array) $resume->experiences) + 1 }};

                function addExperience() {
                    const container = document.getElementById('experiences-container');
                    const newSection = document.createElement('div');
                    newSection.className = 'card shadow mb-3 col-12 experience-section';
                    newSection.innerHTML = `
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="experiences[${experienceIndex}][poste]" class="form-control"
                                            placeholder="Poste:" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="experiences[${experienceIndex}][entreprise]" class="form-control"
                                            placeholder="Entreprise:" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="experiences[${experienceIndex}][dates]" class="form-control"
                                            placeholder="Dates:" required>
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="experiences[${experienceIndex}][description]" class="form-control"
                                            placeholder="Description:" rows="3" required></textarea>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm float-end" onclick="removeExperience(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                    container.appendChild(newSection);
                    experienceIndex++;
                }

                function removeExperience(button) {
                    button.closest('.experience-section')?.remove();
                }
            </script>
        </div>
    </div>
</div>
