<div id="liens-container">
    @if (is_array($liens = json_decode($resume->liens, true)))
        <div class="row p-3 sortable">
            @foreach (json_decode($resume->liens, true) ?? [] as $index => $lien)
                <div class="card shadow border-left-primary col-12 lien-section">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="liens[{{ $index }}][nom]" class="form-control"
                                placeholder="Nom du lien:" value="{{ $lien['nom'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <input type="url" name="liens[{{ $index }}][url]" class="form-control"
                                placeholder="Url du lien:" value="{{ $lien['url'] ?? '' }}" required>
                        </div>
                        @if (!$loop->first)
                            <a class="float-right btn btn-sm btn-danger" onclick="removeLien(this)"><i
                                    class="fa fa-trash"></i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            Aucun lien.
        </div>
    @endif

    <script>
        let lienIndex =
            {{ is_array($liens = json_decode($resume->liens)) ? count($liens) : (is_object($liens) ? count((array) $liens) : 0) }};


        function addLien() {
            const container = document.getElementById('liens-container');
            const newSection = document.createElement('div');
            newSection.className = 'card shadow border-left-primary col-12 lien-section';
            newSection.innerHTML = `
        <div class="card-body">
            <div class="form-group">
                <input type="text" name="liens[${lienIndex}][nom]" class="form-control" placeholder="Nom du lien:" required>
            </div>
            <div class="form-group">
                <input type="url" name="liens[${lienIndex}][url]" class="form-control"
                    placeholder="Url du lien:" required>
            </div>
            <a class="float-right btn btn-sm btn-danger" onclick="removeLien(this)"><i
                    class="fa fa-trash"></i></a>
        </div>
    `;
            container.appendChild(newSection);
            lienIndex++;
        }

        function removeLien(button) {
            const section = button.closest('.lien-section');
            if (section) {
                section.remove();
            }
        }
    </script>
</div>
<a class="float-right btn btn-sm btn-success mb-3" onclick="addLien()"><i class="fa fa-plus"></i></a>
