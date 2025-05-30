<div id="certifications-container">
    @if (is_array($certifications = json_decode($resume->certifications, true)))
        <div class="row p-3 sortable">
            @foreach (json_decode($resume->certifications, true) ?? [] as $index => $certification)
                <div class="card shadow border-left-primary col-12 certification-section">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="certifications[{{ $index }}][nom]" class="form-control"
                                placeholder="Le nom de la certification:" value="{{ $certification['nom'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="certifications[{{ $index }}][organisme]"
                                class="form-control" placeholder="L'organisation:"
                                value="{{ $certification['organisme'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="certifications[{{ $index }}][dates]" class="form-control"
                                placeholder="Dates:" value="{{ $certification['dates'] ?? '' }}" required>
                        </div>
                        @if (!$loop->first)
                            <a class="float-right btn btn-sm btn-danger" onclick="removeCertification(this)"><i
                                    class="fa fa-trash"></i></a>
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

    <script>
        let certificationIndex =
            {{ is_array($certifications = json_decode($resume->certifications)) ? count($certifications) : (is_object($certifications) ? count((array) $certifications) : 0) }};


        function addCertification() {
            const container = document.getElementById('certifications-container');
            const newSection = document.createElement('div');
            newSection.className = 'card shadow border-left-primary col-12 certification-section';
            newSection.innerHTML = `
        <div class="card-body">
            <div class="form-group">
                <input type="text" name="certifications[${certificationIndex}][nom]" class="form-control" placeholder="Le nom de la certification:" required>
            </div>
            <div class="form-group">
                <input type="text" name="certifications[${certificationIndex}][organisme]" class="form-control"
                    placeholder="L'organisation:" required>
            </div>
            <div class="form-group">
                <input type="text" name="certifications[${certificationIndex}][dates]" class="form-control" placeholder="Dates:" required>
            </div>
            <a class="float-right btn btn-sm btn-danger" onclick="removeCertification(this)"><i
                    class="fa fa-trash"></i></a>
        </div>
    `;
            container.appendChild(newSection);
            certificationIndex++;
        }

        function removeCertification(button) {
            const section = button.closest('.certification-section');
            if (section) {
                section.remove();
            }
        }
    </script>
</div>
<a class="float-right btn btn-sm btn-success mb-3" onclick="addCertification()"><i class="fa fa-plus"></i></a>
