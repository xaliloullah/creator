<div id="competences-container">
    @if (is_array($competences = json_decode($resume->competences, true)))
        <div class="row p-3 sortable">
            @foreach (json_decode($resume->competences, true) ?? [] as $index => $competence)
                <div class="card shadow border-left-primary col-12 competence-section">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="competences[{{ $index }}][titre]" class="form-control"
                                placeholder="Titre:" value="{{ $competence['titre'] }}" required>
                        </div>
                        <label>Compétences:</label>
                        <div class="form-group">
                            <select class="select-multiple" multiple="multiple"
                                name="competences[{{ $index }}][competence][]" required>
                                @foreach ($competence['competence'] as $item)
                                    <option value="{{ $item }}" selected>{{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if (!$loop->first)
                            <a class="float-right btn btn-sm btn-danger" onclick="removeCompetence(this)"><i
                                    class="fa fa-trash"></i></a>
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
    <script>
        let competenceIndex =
            {{ is_array($competences = json_decode($resume->competences)) ? count($competences) : (is_object($competences) ? count((array) $competences) : 0) }};

        function addCompetence() {
            const container = document.getElementById('competences-container');
            const newSection = document.createElement('div');
            newSection.className = 'card shadow border-left-primary col-12 competence-section';
            newSection.innerHTML = `
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="competences[${competenceIndex}][titre]" class="form-control" placeholder="Titre:" required>
                    </div>
                    <label>Compétences:</label>
                    <div class="form-group">
                        <select class="select-multiple form-control" multiple="multiple" name="competences[${competenceIndex}][competence][]" required>
                        </select>
                    </div>
                    <a class="float-right btn btn-sm btn-danger"
                        onclick="removeCompetence(this)"><i class="fa fa-trash"></i></a>
                </div>
            `;
            container.appendChild(newSection);
            $(newSection).find('.select-multiple').select2({
                tags: true,
                placeholder: "...",
                allowClear: true,
                tokenSeparators: [",", " "],
            });

            competenceIndex++;
        }

        function removeCompetence(button) {
            const section = button.closest('.competence-section');
            if (section) {
                section.remove();
            }
        }
    </script>
</div>
<a class="float-right btn btn-sm btn-success mb-3" onclick="addCompetence()"><i class="fa fa-plus"></i></a>
