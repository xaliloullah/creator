<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3"><input type="text" name="parametre[certification]"
                    class="form-control-plaintext m-0 text-dark"
                    value="{{ $resume->parametre['certification'] ?? 'Certifications' }}"></h5>
            <div id="certifications-container">
                @if ($resume->certifications)
                    <div class="row p-3 sortable">
                        @foreach ($resume->certifications as $index => $certification)
                            <div class="card shadow mb-3 col-12 certification-section">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="certifications[{{ $index }}][nom]"
                                            class="form-control" placeholder="Le nom de la certification:"
                                            value="{{ $certification['nom'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="certifications[{{ $index }}][organisme]"
                                            class="form-control" placeholder="L'organisation:"
                                            value="{{ $certification['organisme'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="certifications[{{ $index }}][dates]"
                                            class="form-control" placeholder="Dates:"
                                            value="{{ $certification['dates'] ?? '' }}" required>
                                    </div>
                                    @if (!$loop->first)
                                        <button type="button" class="btn btn-outline-danger btn-sm float-end"
                                            onclick="removeCertification(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        Aucune certification.
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-success btn-sm mb-3 float-end" onclick="addCertification()">
                <i class="bi bi-plus"></i> Ajouter
            </button>

            <script>
                let certificationIndex = {{ count((array) $resume->certifications) + 1 }};

                function addCertification() {
                    const container = document.getElementById('certifications-container');
                    const newSection = document.createElement('div');
                    newSection.className = 'card shadow mb-3 col-12 certification-section';
                    newSection.innerHTML = `
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="text" name="certifications[${certificationIndex}][nom]" class="form-control"
                                            placeholder="Le nom de la certification:" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="certifications[${certificationIndex}][organisme]" class="form-control"
                                            placeholder="L'organisation:" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="certifications[${certificationIndex}][dates]" class="form-control"
                                            placeholder="Dates:" required>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm float-end" onclick="removeCertification(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                    container.appendChild(newSection);
                    certificationIndex++;
                }

                function removeCertification(button) {
                    button.closest('.certification-section')?.remove();
                }
            </script>

        </div>
    </div>
</div> 