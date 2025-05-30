<div id="formations-container">
    @if (is_array($formations = json_decode($resume->formations, true)))
        <div class="row p-3 sortable">
            @foreach (json_decode($resume->formations, true) ?? [] as $index => $formation)
                <div class="card shadow border-left-primary col-12 formation-section">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="formations[{{ $index }}][diplome]" class="form-control"
                                placeholder="diplôme:" value="{{ $formation['diplome'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="formations[{{ $index }}][etablissement]"
                                class="form-control" placeholder="établissement:"
                                value="{{ $formation['etablissement'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="formations[{{ $index }}][dates]" class="form-control"
                                placeholder="Dates:" value="{{ $formation['dates'] ?? '' }}" required>
                        </div>
                        @if (!$loop->first)
                            <a class="float-right btn btn-sm btn-danger" onclick="removeFormation(this)"><i
                                    class="fa fa-trash"></i></a>
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

    <script>
        let formationIndex =
            {{ is_array($formations = json_decode($resume->formations)) ? count($formations) : (is_object($formations) ? count((array) $formations) : 0) }};


        function addFormation() {
            const container = document.getElementById('formations-container');
            const newSection = document.createElement('div');
            newSection.className = 'card shadow border-left-primary col-12 formation-section';
            newSection.innerHTML = `
        <div class="card-body">
            <div class="form-group">
                <input type="text" name="formations[${formationIndex}][diplome]" class="form-control" placeholder="diplôme:" required>
            </div>
            <div class="form-group">
                <input type="text" name="formations[${formationIndex}][etablissement]" class="form-control"
                    placeholder="établissement:" required>
            </div>
            <div class="form-group">
                <input type="text" name="formations[${formationIndex}][dates]" class="form-control" placeholder="Dates:" required>
            </div>
            <a class="float-right btn btn-sm btn-danger" onclick="removeFormation(this)"><i
                    class="fa fa-trash"></i></a>
        </div>
    `;
            container.appendChild(newSection);
            formationIndex++;
        }

        function removeFormation(button) {
            const section = button.closest('.formation-section');
            if (section) {
                section.remove();
            }
        }
    </script>
</div>
<a class="float-right btn btn-sm btn-success mb-3" onclick="addFormation()"><i class="fa fa-plus"></i></a>
