<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3"><input type="text" name="parametre[interet]" class="form-control-plaintext m-0 text-dark"
                    value="{{ $resume->parametre['interet'] ?? 'Interets' }}"></h5>
            <div id="interets-container">
                @if ($resume->interets)
                    <div class="row p-3 sortable">
                        @foreach ($resume->interets as $index => $interet)
                            <div class="card shadow mb-3 col-12 interet-section">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="interets[{{ $index }}][interet]"
                                            class="form-control" placeholder="Intérêt:"
                                            value="{{ $interet['interet'] ?? '' }}" required>
                                    </div>
                                    @if (!$loop->first)
                                        <button type="button" class="btn btn-outline-danger btn-sm float-end"
                                            onclick="removeInteret(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        Aucun intérêt.
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-success btn-sm mb-3 float-end" onclick="addInteret()">
                <i class="bi bi-plus"></i> Ajouter
            </button>

            <script>
                let interetIndex = {{ count((array) $resume->interets) + 1 }};

                function addInteret() {
                    const container = document.getElementById('interets-container');
                    const newSection = document.createElement('div');
                    newSection.className = 'card shadow mb-3 col-12 interet-section';
                    newSection.innerHTML = `
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="interets[${interetIndex}][interet]" class="form-control" placeholder="Intérêt:"
                                                required>
                                            <button type="button" class="btn btn-danger float-end" onclick="removeInteret(this)">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            `;
                    container.appendChild(newSection);
                    interetIndex++;
                }

                function removeInteret(button) {
                    button.closest('.interet-section')?.remove();
                }
            </script>
        </div>
    </div>
</div>
