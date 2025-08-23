@extends('dashboard.index')
@section('title', 'factures')
@section('subtitle', 'Nouveau')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajouter une nouvelle facture</h1>
            <p class="text-muted mb-0">
                Remplissez le formulaire ci-dessous pour creer un facture.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('factures.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('factures.store') }}" method="POST" enctype="multipart/form-data" class="validate">
        @csrf
        <div class="row">
            {{-- <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Clients</h5>
                            <div class="row g-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Informations générales</h5>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Désignation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="designation" name="designation"
                                        placeholder="Désignation" value="{{ old('designation') }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date d'émission <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date_emission" name="date_emission"
                                        placeholder="Date emission" value="{{ old('date_emission', date('Y-m-d')) }}"
                                        required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date d'échéance</label>
                                    <input type="date" class="form-control" id="date_echeance" name="date_echeance"
                                        placeholder="Date d'échéance" value="{{ old('date_echeance') }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="parametre[type]">Type de factures</label>

                                    <select class="form-select" id="parametre[type]" name="parametre[type]">
                                        @foreach (['simple', 'avance'] as $type)
                                            <option value="{{ $type }}"
                                                @if (old('parametre.type') == $type) selected @endif>Factures
                                                {{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="client_id">Clients</label>
                                    <select class="form-select tags-option" id="client_id" name="client_id">
                                        <option value="" selected disabled>
                                            Sélectionner un client
                                        </option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client }}"
                                                @if (old('client_id') == $client->id) selected @endif>
                                                {{ $client->prenom }} {{ $client->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="text" name="articles[head][designation]"
                                            class="form-control-plaintext" value="Désignation" required>
                                    </th>
                                    <th class="factures-avance" width="9%">
                                        <input type="text" name="articles[head][quantite]" class="form-control-plaintext"
                                            value="Quantité" required>
                                    </th>
                                    <th class="factures-avance" width="20%"><input type="text"
                                            name="articles[head][prix]" class="form-control-plaintext" value="Prix Unitaire"
                                            required></th>
                                    <th width="20%"><input type="text" name="articles[head][montant]"
                                            class="form-control-plaintext" value="Montant" required>
                                    </th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea type="text" class="form-control" name="articles[body][0][designation]" placeholder="designation..."
                                            rows="3" required></textarea>
                                    </td>
                                    <td class="factures-avance"><input type="number" class="form-control"
                                            name="articles[body][0][quantite]" min="1"
                                            oninput="calculerMontant(this)" required>
                                    </td>
                                    <td class="factures-avance"><input type="number" class="form-control"
                                            name="articles[body][0][prix]" min="0" oninput="calculerMontant(this)"
                                            required></td>
                                    <td><input type="number" class="form-control" name="articles[body][0][montant]"
                                            min="0" oninput="calculerTotal()" required></td>
                                    <td><button type="button" class="btn btn-success" onclick="addArticle();"><i
                                                class="bi bi-plus"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <td class="font-weight-bold text-light">Total</td>
                                    <td class="factures-avance" id="total-quantite">0</td>
                                    <td class="factures-avance" id="total-prix">0</td>
                                    <td id="total-montant">0</td>
                                    <td id=""></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="mb-3">Informations supplémentaires</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control editor-simple" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="titre-conditions"><input type="text" id="titre-conditions"
                                                name="parametre[titre-conditions]"
                                                class="form-control form-control-sm mb-3" value="Conditions"
                                                required></label>

                                        <textarea type="text" class="form-control editor-simple" id="conditions" name="conditions"
                                            placeholder="Conditions">Cette facture est valable 30 jours à compter de la date d'émission.</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="titre-tva"><input type="text" id="titre-tva"
                                                name="parametre[titre-tva]" class="form-control form-control-sm mb-3"
                                                value="TVA" required></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="tva" id="tva"
                                                placeholder="TVA">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <label class="form-label">Conditions</label>
                                    <select class="form-select tags" multiple name="condition[]">
                                        @foreach (old('condition', []) as $condition)
                                            <option value="{{ $condition }}" selected>{{ $condition }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-12">
                                    <label class="form-label">Tags</label>
                                    <select class="form-select tags" multiple name="tags[]">
                                        @foreach (old('tags', []) as $tags)
                                            <option value="{{ $tags }}" selected>{{ $tags }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea type="text" class="form-control" id="message" name="parametre[message]" placeholder="Message">Merci pour votre confiance !</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-ghost shadow-lg sticky-bottom">
                    <div class="card-body p-3">
                        <div class="d-flex gap-2 float-end">
                            <button type="reset" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i>Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4">
                <div class="card card-ghost shadow-lg sticky-top">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Aide</h5>
                        <div class="alert alert-info mb-0">
                            <h6 class="alert-heading">
                                <i class="bi bi-info-circle me-2"></i>Conseils
                            </h6>
                            <ul class="mt-2 mb-0 ps-3">
                                <li class="mb-1">Assurez-vous de remplir tous les champs obligatoires (<span
                                        class="text-danger">*</span>).</li>
                                <li class="mb-1">Vérifiez les informations saisies avant de valider.</li>
                                <li>En cas de problème, contactez l'administrateur du système.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </form>
    <script>
        let articleIndex = 1;

        function calculerMontant(input) {
            const row = input.closest('tr');
            const quantite = parseFloat(row.querySelector('[name^="articles[body]"][name$="[quantite]"]').value) || 0;
            const prix = parseFloat(row.querySelector('[name^="articles[body]"][name$="[prix]"]').value) || 0;
            const montant = quantite * prix;
            row.querySelector('[name^="articles[body]"][name$="[montant]"]').value = montant;
            calculerTotal();
        }

        function calculerTotal() {
            let totalQuantite = 0;
            let totalPrix = 0;
            let totalMontant = 0;
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                totalQuantite += parseFloat(row.querySelector('[name^="articles[body]"][name$="[quantite]"]')
                    .value) || 0;
                totalPrix += parseFloat(row.querySelector('[name^="articles[body]"][name$="[prix]"]').value) || 0;
                totalMontant += parseFloat(row.querySelector('[name^="articles[body]"][name$="[montant]"]')
                    .value) || 0;
            });
            document.getElementById('total-quantite').textContent = totalQuantite;
            document.getElementById('total-prix').textContent = totalPrix;
            document.getElementById('total-montant').textContent = totalMontant;
        }



        document.getElementById('parametre[type]').addEventListener('change', () => {
            togglefacturesType(document.getElementById('parametre[type]').value);
        });

        function togglefacturesType(typefactures) {
            const showAvance = typefactures === 'avance';
            document.querySelectorAll('.factures-avance').forEach(el => {
                el.style.display = showAvance ? '' : 'none';
                el.querySelectorAll('input').forEach(input => input.disabled = !showAvance);
            });
        }
        togglefacturesType(document.getElementById('parametre[type]').value);

        function addArticle() {
            const tbody = document.querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML =
                `<td><textarea class="form-control" name="articles[body][${articleIndex}][designation]" placeholder="designation..." rows="3" required></textarea></td>
                <td class="factures-avance"><input type="number" class="form-control" name="articles[body][${articleIndex}][quantite]" min="1" oninput="calculerMontant(this)" required></td>
                <td class="factures-avance"><input type="number" class="form-control" name="articles[body][${articleIndex}][prix]" min="0" oninput="calculerMontant(this)" required></td>
                <td><input type="number" class="form-control" name="articles[body][${articleIndex}][montant]" min="0" oninput="calculerTotal()" required></td>
                <td><button type="button" class="btn btn-danger" onclick="removeArticle(this)"><i class="bi bi-trash"></i></button></td>`;
            tbody.appendChild(newRow);
            togglefacturesType(document.getElementById('parametre[type]').value);
            articleIndex++;
            editorSimple();

        }

        function removeArticle(button) {
            button.closest('tr').remove();
            calculerTotal();
        }
        calculerTotal();
    </script>
@endsection
