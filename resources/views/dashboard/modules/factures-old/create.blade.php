@extends('dashboard.index')
@section('title', 'Factures')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Ajouter une facture
                <a href="{{ route('factures.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('factures.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titre">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" value="Facture"
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <a class="float-right btn btn-sm btn-outline-secondary"
                                type="button" id="rechercher-un-client" data-toggle="modal"
                                data-target="#modal-search-client">Rechercher un client<i class="fa fa-search ml-3"></i>
                            </a>
                            <input type="hidden" class="form-control" id="client_id" name="client_id" required readonly
                                hidden>
                            <input type="text" class="form-control" id="client_name" name="client_name" required
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_emission">Date emission</label>
                            <input type="date" class="form-control" id="date_emission" name="date_emission"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_echeance">Date d'échéance</label>
                            <input type="date" id="date_echeance" name="date_echeance" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="parametre[type]">Type de factures</label>
                            <select class="form-control" id="parametre[type]" name="parametre[type]">
                                @foreach (['simple', 'avance'] as $type)
                                    <option value="{{ $type }}">factures {{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive form-group mb-3">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <input type="text" name="articles[head][designation]"
                                                class="form-control-plaintext m-0 font-weight-bold text-light"
                                                value="Désignation" required>
                                        </th>
                                        <th width="10%" class="factures-avance">
                                            <input type="text" name="articles[head][quantite]"
                                                class="form-control-plaintext m-0 font-weight-bold text-light"
                                                value="Quantité" required>
                                        </th>
                                        <th width="15%" class="factures-avance"><input type="text"
                                                name="articles[head][prix]"
                                                class="form-control-plaintext m-0 font-weight-bold text-light"
                                                value="Prix Unitaire" required></th>
                                        <th width="15%"><input type="text" name="articles[head][montant]"
                                                class="form-control-plaintext font-weight-bold text-light" value="Montant"
                                                required>
                                        </th>
                                        <th width="1%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <textarea type="text" class="form-control editor-simple" name="articles[body][0][designation]"
                                                placeholder="designation..."></textarea>
                                        </td>
                                        <td class="factures-avance"><input type="number" class="form-control"
                                                name="articles[body][0][quantite]" min="1"
                                                oninput="calculerMontant(this)" required>
                                        </td>
                                        <td class="factures-avance"><input type="number" class="form-control"
                                                name="articles[body][0][prix]" min="0"
                                                oninput="calculerMontant(this)" required></td>
                                        <td><input type="number" class="form-control" name="articles[body][0][montant]"
                                                min="0" oninput="calculerTotal()" required></td>
                                        <td><button type="button" class="btn btn-success" onclick="addArticle();"><i
                                                    class="fas fa-plus"></i></button></td>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titre-conditions"><input type="text" id="titre-conditions"
                                    name="parametre[titre-conditions]" class="form-control form-control-sm"
                                    value="Conditions" required></label>

                            <textarea type="text" class="form-control editor-simple" id="conditions" name="conditions"
                                placeholder="Conditions">Cette facture est valable 30 jours à compter de la date d'émission.</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titre-tva"><input type="text" id="titre-tva" name="parametre[titre-tva]"
                                    class="form-control form-control-sm" value="TVA" required></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="tva" id="tva"
                                    placeholder="TVA">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="devise">Devise</label>
                            <div class="input-group">
                                <select type="text" class="form-control" name="devise" id="devise" required>
                                    <option value="" selected disabled>Devise</option>
                                    @foreach ($devises as $index => $devise)
                                        <option value="{{ $index }}">{{ $devise }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea type="text" class="form-control" id="message" name="parametre[message]" placeholder="Message">Merci pour votre confiance !</textarea>
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
                `<td><textarea class="form-control editor-simple" name="articles[body][${articleIndex}][designation]" placeholder="designation..."></textarea></td>
                <td class="factures-avance"><input type="number" class="form-control" name="articles[body][${articleIndex}][quantite]" min="1" oninput="calculerMontant(this)" required></td>
                <td class="factures-avance"><input type="number" class="form-control" name="articles[body][${articleIndex}][prix]" min="0" oninput="calculerMontant(this)" required></td>
                <td><input type="number" class="form-control" name="articles[body][${articleIndex}][montant]" min="0" oninput="calculerTotal()" required></td>
                <td><button type="button" class="btn btn-danger" onclick="removeArticle(this)"><i class="fas fa-trash"></i></button></td>`;
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
    @include('dashboard.pages.factures.includes.modal-search-client')
@endsection
