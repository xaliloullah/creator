<div id="langues-container">
    @if (is_array($langues = json_decode($resume->langues, true)))
        <div class="row p-3 sortable">
            @foreach (json_decode($resume->langues, true) ?? [] as $index => $langue)
                <div class="card shadow border-left-primary col-12 langue-section">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="text" name="langues[{{ $index }}][langue]" class="form-control"
                                    placeholder="Langue:" value="{{ $langue['langue'] ?? '' }}" required>
                            </div>
                            <div class="form-group col-6">
                                <input type="number" name="langues[{{ $index }}][niveau]" class="form-control"
                                placeholder="Niveau (1 - 100):" min="1" max="100" value="{{ $langue['niveau'] ?? '' }}" required>
                            </div>
                        </div>
                        @if (!$loop->first)
                            <a class="float-right btn btn-sm btn-danger" onclick="removeLangue(this)"><i
                                    class="fa fa-trash"></i></a>
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
    <script>
        let langueIndex =
            {{ is_array($langues = json_decode($resume->langues)) ? count($langues) : (is_object($langues) ? count((array) $langues) : 0) }};


        function addLangue() {
            const container = document.getElementById('langues-container');
            const newSection = document.createElement('div');
            newSection.className = 'card shadow border-left-primary col-12 langue-section';
            newSection.innerHTML = `
            <div class="card-body">
            <div class="row">
                <div class="form-group col-6">
                    <input type="text" name="langues[${langueIndex}][langue]" class="form-control" placeholder="Langue:" required>
                </div>
                <div class="form-group col-6">
                    <input type="number" name="langues[${langueIndex}][niveau]" class="form-control"
                        placeholder="Niveau (1 - 100):" min="1" max="100" required>
                </div>
            </div>
                <a class="float-right btn btn-sm btn-danger" onclick="removeLangue(this)"><i
                        class="fa fa-trash"></i></a>
            </div>
        `;
            container.appendChild(newSection);
            langueIndex++;
        }

        function removeLangue(button) {
            const section = button.closest('.langue-section');
            if (section) {
                section.remove();
            }
        }
    </script>
</div>
<a class="float-right btn btn-sm btn-success mb-3" onclick="addLangue()"><i class="fa fa-plus"></i></a>
