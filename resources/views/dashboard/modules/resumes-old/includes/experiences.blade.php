<div id="experiences-container">
    @if (is_array($experiences = json_decode($resume->experiences, true)))
        <div class="row p-3 sortable">
            @foreach (json_decode($resume->experiences, true) ?? [] as $index => $experience)
                <div class="card shadow border-left-primary col-12 experience-section">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="experiences[{{ $index }}][poste]" class="form-control"
                                placeholder="Poste:" value="{{ $experience['poste'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="experiences[{{ $index }}][entreprise]"
                                class="form-control" placeholder="Entreprise:"
                                value="{{ $experience['entreprise'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="experiences[{{ $index }}][dates]" class="form-control"
                                placeholder="Dates:" value="{{ $experience['dates'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <textarea type="text" name="experiences[{{ $index }}][description]" class="form-control"
                                placeholder="Description:" required>{{ $experience['description'] ?? '' }}</textarea>
                        </div>
                        @if (!$loop->first)
                            <a class="float-right btn btn-sm btn-danger" onclick="removeExperience(this)"><i
                                    class="fa fa-trash"></i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            Aucune experience.
        </div>
    @endif
    <script>
        let experienceIndex =
            {{ is_array($experiences = json_decode($resume->experiences)) ? count($experiences) : (is_object($experiences) ? count((array) $experiences) : 0) }};

        function addExperience() {
            const container = document.getElementById('experiences-container');
            const newSection = document.createElement('div');
            newSection.className = 'card shadow border-left-primary col-12 experience-section';
            newSection.innerHTML = `
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="experiences[${experienceIndex}][poste]" class="form-control" placeholder="Poste:" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="experiences[${experienceIndex}][entreprise]" class="form-control"
                            placeholder="Entreprise:" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="experiences[${experienceIndex}][dates]" class="form-control" placeholder="Dates:" required>
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="experiences[${experienceIndex}][description]" class="form-control" placeholder="Description:" required></textarea>
                    </div>
                    <a class="float-right btn btn-sm btn-danger" onclick="removeExperience(this)"><i
                            class="fa fa-trash"></i></a>
                </div>
            `;
            container.appendChild(newSection);
            experienceIndex++;
        }

        function removeExperience(button) {
            const section = button.closest('.experience-section');
            if (section) {
                section.remove();
            }
        }
    </script>
</div>
<a class="float-right btn btn-sm btn-success mb-3" onclick="addExperience()"><i class="fa fa-plus"></i></a>
