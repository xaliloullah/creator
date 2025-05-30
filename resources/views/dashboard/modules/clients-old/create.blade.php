@extends('dashboard.index')
@section('title', 'Clients')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Ajouter un client
                <a href="{{ route('clients.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="profil">Profil</label>
                            <div class="image-preview">
                                <input class="d-none" name="image" id="image" type="file" />
                                <img src="{{ asset('assets/images/default-user.png') }}" alt="img"
                                    id="preview-image" />
                                <label for="image" class="btn btn-sm btn-secondary btn-edit" id="btn-edit">
                                    <i class="fa fa-edit"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom"
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telephones">Téléphone</label><a class="float-right btn btn-sm btn-success"
                                onclick="addTelephone()"><i class="fa fa-plus"></i>
                                Ajouter un téléphone</a>
                            <div id="telephones-container">
                                <div class="telephone-section">
                                    <div class="input-group mb-3">
                                        <input type="text" name="telephones[0]" class="form-control"
                                            placeholder="Téléphone" required>
                                        <a class="ml-1 btn btn-danger" onclick="removeTelephone(this)"><i
                                                class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                            <script>
                                let telephoneIndex = 1;

                                function addTelephone() {
                                    const container = document.getElementById('telephones-container');
                                    const newSection = document.createElement('div');
                                    newSection.className = 'telephone-section';
                                    newSection.innerHTML = `
                                    <div class="input-group mb-3">
                                        <input type="text" name="telephones[${telephoneIndex}]" class="form-control" placeholder="Téléphone" required>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rue">Numéro de rue, nom de la rue</label>
                            <input type="text" class="form-control" placeholder="Numéro de rue, nom de la rue"
                                id="rue" name="adresse[rue]" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="complement">Complément d'adresse (facultatif)</label>
                            <input type="text" class="form-control" placeholder="Complément d'adresse" id="complement"
                                name="adresse[complement]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code_postal">Code postal</label>
                            <input type="text" class="form-control" placeholder="Code Postal" id="code_postal"
                                name="adresse[code_postal]" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ville">Ville</label>
                            <input type="text" class="form-control" placeholder="Ville" id="ville"
                                name="adresse[ville]" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pays">Pays</label>
                            <input type="text" class="form-control" placeholder="Pays" id="pays"
                                name="adresse[pays]" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="entreprise">Entreprise</label>
                            <input type="text" class="form-control" id="entreprise" name="entreprise"
                                placeholder="entreprise">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fonction">Fonction</label>
                            <input type="text" class="form-control" id="fonction" name="fonction"
                                placeholder="fonction">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="civilite">Civilite</label>
                            <input type="text" class="form-control" id="civilite" name="civilite"
                                placeholder="civilite">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="site_web">Site web</label>
                            <select name="site_web[]" id="site_web" class="form-control select-multiple"
                                multiple="multiple" placeholder="Site web"></select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="reset" class="btn btn-danger">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
@endsection
