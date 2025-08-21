<div id="interets-container">
    @if (is_array($interets = json_decode($resume->interets, true)))
        <div class="row p-3 sortable">
            @foreach (json_decode($resume->interets, true) ?? [] as $index => $interet)
                <div class="card shadow border-left-primary col-12 interet-section">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <input type="text" name="interets[{{ $index }}][interet]" class="form-control"
                                    placeholder="interet:" value="{{ $interet['interet'] ?? '' }}" required>
                            </div> 
                        </div>
                        @if (!$loop->first)
                            <a class="float-right btn btn-sm btn-danger" onclick="removeInteret(this)"><i class="fa fa-trash"></i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            Aucune interet.
        </div>
    @endif
    <script>
        let interetIndex =
            {{ is_array($interets = json_decode($resume->interets)) ? count($interets) : (is_object($interets) ? count((array) $interets) : 0) }};


        function addInteret() {
            const container = document.getElementById('interets-container');
            const newSection = document.createElement('div');
            newSection.className = 'card shadow border-left-primary col-12 interet-section';
            newSection.innerHTML = `
            <div class="card-body">
            <div class="row">
                <div class="form-group col-12">
                    <input type="text" name="interets[${interetIndex}][interet]" class="form-control" placeholder="interet:" required>
                </div> 
            </div>
                <a class="float-right btn btn-sm btn-danger" onclick="removeInteret(this)"><i
                        class="fa fa-trash"></i></a>
            </div>
        `;
            container.appendChild(newSection);
            interetIndex++;
        }

        function removeInteret(button) {
            const section = button.closest('.interet-section');
            if (section) {
                section.remove();
            }
        }
    </script>
</div>
<a class="float-right btn btn-sm btn-success mb-3" onclick="addInteret()"><i class="fa fa-plus"></i></a>
