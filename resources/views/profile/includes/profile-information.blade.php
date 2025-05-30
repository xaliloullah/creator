<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-5 border-left-info">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>
            <a href="#profile-information" class="d-block card-header py-3" data-toggle="collapse" role="button"
                aria-expanded="true" aria-controls="profile-information">
                <h6 class="m-0 font-weight-bold text-info text-uppercase"><i
                        class="fa fa-user-circle mr-3"></i>Informations
                    de profil</h6>
            </a>
            <div class="collapse show" id="profile-information">
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label" for="profil">Profil</label>
                                <div class="image-preview">
                                    <input class="d-none" name="image" id="image" type="file" />
                                    <img src="{{ asset('assets/images/' . ($user->image ? 'users/' . $user->image : 'default-user.png')) }}"
                                        alt="img" id="preview-image" />

                                    <label for="image" class="btn btn-sm btn-secondary btn-edit" id="btn-edit">
                                        <i class="fa fa-edit"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-lg-8">
                                <label class="form-label" for="prenom">Prenom</label>
                                <input class="form-control form-control-sm" id="prenom" name="prenom" type="text"
                                    value="{{ old('prenom', $user->prenom) }}" required autocomplete="prenom">
                                <label class="form-label" for="nom">Nom</label>
                                <input class="form-control form-control-sm" id="nom" name="nom" type="text"
                                    value="{{ old('nom', $user->nom) }}" autocomplete="nom">
                                <label class="form-label" for="email">Email</label>
                                <input id="email" name="email" type="email" class="form-control form-control-sm"
                                    value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                    <button form="send-verification" class="btn btn-sm btn-success">Cliquez ici pour
                                        renvoyer l'e-mail de vérification.</button>
                                @endif
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="roles">Roles</label>
                                    <input class="form-control form-control-sm" id="roles" name="roles"
                                        type="text" value="{{ old('roles', $user->roles) }}" required
                                        autocomplete="roles" readonly>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telephones">Téléphone</label><a class="float-right btn btn-sm btn-success" onclick="addTelephone()"><i
                                        class="fa fa-plus"></i>
                                    Ajouter un téléphone</a>
                                    <div id="telephones-container">
                                        @if (is_array($telephones = json_decode($user->telephones, true)))
                                            @foreach (json_decode($user->telephones, true) ?? [] as $index => $telephone)
                                                <div class="telephone-section">
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="telephones[{{ $index }}]"
                                                            class="form-control form-control-sm" placeholder="téléphone"
                                                            value="{{ $telephone }}" required>
                                                        @if (!$loop->first)
                                                            <a class="ml-1 btn btn-sm btn-danger"
                                                                onclick="removeTelephone(this)"><i
                                                                    class="fa fa-trash"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <script>
                                        let telephoneIndex =
                                            {{ is_array($telephones = json_decode($user->telephones)) ? count($telephones) : (is_object($telephones) ? count((array) $telephones) : 0) }};

                                        function addTelephone() {
                                            const container = document.getElementById('telephones-container');
                                            const newSection = document.createElement('div');
                                            newSection.className = 'telephone-section';
                                            newSection.innerHTML = `
                                            <div class="input-group mb-3">
                                                <input type="text" name="telephones[${telephoneIndex}]" class="form-control form-control-sm" placeholder="téléphone:" required>
                                                <a class="ml-1  btn btn-sm btn-danger" onclick="removeTelephone(this)"><i class="fa fa-trash"></i></a>
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
                                $adresse = json_decode($user->adresse, true);
                            @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rue">Numéro de rue, nom de la rue</label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Numéro de rue, nom de la rue" id="rue" name="adresse[rue]"
                                        value="{{ $adresse['rue'] ?? null }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="complement">Complément d'adresse (facultatif)</label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Complément d'adresse" id="complement" name="adresse[complement]"
                                        value="{{ $adresse['complement'] ?? null }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code_postal">Code postal</label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Code Postal" id="code_postal" name="adresse[code_postal]"
                                        value="{{ $adresse['code_postal'] ?? null }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ville">Ville</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Ville"
                                        id="ville" name="adresse[ville]" value="{{ $adresse['ville'] ?? null }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pays">Pays</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Pays"
                                        id="pays" name="adresse[pays]" value="{{ $adresse['pays'] ?? null }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-outline-secondary" type="submit">Sauvegarder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
