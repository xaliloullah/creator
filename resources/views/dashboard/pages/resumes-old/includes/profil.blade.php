<div class="row">
    <div class="form-group col-lg-12">
        <label class="form-label" for="profil">Profil</label>
        <div class="image-preview">
            <input class="d-none" name="image" id="image" type="file" />
            @if ($resume->image ?? null)
                <img src="{{ asset('storage/images/resumes/' . $resume->image) }}" alt="img" id="preview-image" />
            @else
                <img src="{{ asset('assets/images/default-user.png') }}" alt="img" id="preview-image" />
            @endif
            <label for="image" class="btn btn-sm btn-secondary btn-edit" id="btn-edit">
                <i class="fa fa-edit"></i>
            </label>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="prenom">Prenom</label>
        <input class="form-control" id="prenom" name="prenom" type="text"
            value="{{ old('prenom', $resume->prenom) }}" required autocomplete="prenom">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="nom">Nom</label>
        <input class="form-control" id="nom" name="nom" type="text" value="{{ old('nom', $resume->nom) }}"
            autocomplete="nom">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="email">Email</label>
        <input id="email" name="email" type="email" class="form-control"
            value="{{ old('email', $resume->email) }}" required autocomplete="username">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="permis">Permis</label>
        <select class="form-control form-control-sm select-multiple" id="permis" name="permis[]" multiple="multiple">
            {{-- @php
                $permisList = [
                    'A1',
                    'A2',
                    'A',
                    'B',
                    'B1',
                    'B+E',
                    'C',
                    'C+E',
                    'D',
                    'D+E',
                    'F',
                    'BE',
                    'L',
                    'M',
                    'Permis probatoire',
                    'Permis international',
                ];
                $selectedPermis = json_decode($resume->permis, true) ?? [];
            @endphp

            @foreach ($permisList as $permi)
                @php
                    $selected = in_array($permi, $selectedPermis) ? 'selected' : '';
                @endphp
                <option value="{{ $permi }}" {{ $selected }}> {{ $permi }}</option>
            @endforeach

            @foreach ($selectedPermis as $permi)
                @if (!in_array($permi, $permisList))
                    <option value="{{ $permi }}" selected>{{ $permi }}</option>
                @endif
            @endforeach
            --}}
            {{-- @foreach (json_decode($resume->permis, true) ?? [] as $permi)
                <option value="{{ $permi }}" selected>{{ $permi }}</option>
            @endforeach --}}

        </select>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label for="telephones">Téléphone</label><a class="float-right btn btn-sm btn-success"
                onclick="addTelephone()"><i class="fa fa-plus"></i>
                Ajouter un téléphone</a>
            <div id="telephones-container">
                @if (is_array($telephones = json_decode($resume->telephones, true)))
                    @foreach (json_decode($resume->telephones, true) ?? [] as $index => $telephone)
                        <div class="telephone-section">
                            <div class="input-group mb-3">
                                <input type="text" name="telephones[{{ $index }}]" class="form-control"
                                    placeholder="téléphone" value="{{ $telephone }}" required>
                                @if (!$loop->first)
                                    <a class="ml-1 btn btn-danger" onclick="removeTelephone(this)"><i
                                            class="fa fa-trash"></i></a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <script>
                let telephoneIndex =
                    {{ is_array($telephones = json_decode($resume->telephones)) ? count($telephones) : (is_object($telephones) ? count((array) $telephones) : 0) }};

                function addTelephone() {
                    const container = document.getElementById('telephones-container');
                    const newSection = document.createElement('div');
                    newSection.className = 'telephone-section';
                    newSection.innerHTML = `
                    <div class="input-group mb-3">
                        <input type="text" name="telephones[${telephoneIndex}]" class="form-control" placeholder="téléphone:" required>
                        <a class="ml-1 btn btn-danger" onclick="removeTelephone(this)"><i class="fa fa-trash"></i></a>
                        </div>
                    `;
                    container.appendChild(newSection);
                    telephoneIndex++;
                }

                function removeTelephone(button) {
                    const section = button.closest('.telephone-section');
                    if (section) {
                        section.remove();
                    }
                }
            </script>
        </div>
    </div>
    @php
        $adresse = json_decode($resume->adresse, true);
    @endphp
    <div class="col-md-6">
        <div class="form-group">
            <label for="rue">Numéro de rue, nom de la rue</label>
            <input type="text" class="form-control" placeholder="Numéro de rue, nom de la rue" id="rue"
                name="adresse[rue]" value="{{ $adresse['rue'] ?? null }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="complement">Complément d'adresse
                (facultatif)</label>
            <input type="text" class="form-control" placeholder="Complément d'adresse" id="complement"
                name="adresse[complement]" value="{{ $adresse['complement'] ?? null }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="code_postal">Code postal</label>
            <input type="text" class="form-control" placeholder="Code Postal" id="code_postal"
                name="adresse[code_postal]" value="{{ $adresse['code_postal'] ?? null }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" class="form-control" placeholder="Ville" id="ville" name="adresse[ville]"
                value="{{ $adresse['ville'] ?? null }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="pays">Pays</label>
            <input type="text" class="form-control" placeholder="Pays" id="pays" name="adresse[pays]"
                value="{{ $adresse['pays'] ?? null }}">
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="titre">Titre</label>
        <input class="form-control" id="titre" name="titre" type="text" placeholder="Titre"
            value="{{ $resume->titre }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="lieu_naissance">Lieu de naissance</label>
        <input class="form-control" id="lieu_naissance" name="lieu_naissance" type="text"
            value="{{ $resume->lieu_naissance }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="date_naissance">Date de naissance</label>
        <input class="form-control" id="date_naissance" name="date_naissance" type="date"
            value="{{ $resume->date_naissance }}">
    </div>
    <div class="form-group col-lg-12">
        <label class="form-label" for="description">Description</label>
        <textarea name="description" id="description" class="editor">
            {!! $resume->description !!}
        </textarea>
    </div>
</div>
