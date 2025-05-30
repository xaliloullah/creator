@extends('dashboard.index')
@section('title', 'Contrats')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Ajouter un contrat
                <a href="{{ route('contrats.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('contrats.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titre">Titre</label>
                            <input type="text" class="form-control text-uppercase" id="titre" name="titre"
                                value="Contrat" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select class="form-control" id="client_id" name="client_id" required>
                                <option value="" selected disabled>Choisir un Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">
                                        {{ $client->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive form-group mb-3">
                            <table class="table" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="100%">
                                            <input type="text" class="col-md-6 form-control form-control-sm mb-3"
                                                name="articles[body][0][section]" placeholder="Section" required>
                                            <textarea type="text" class="form-control editor-simple" name="articles[body][0][description]"
                                                placeholder="Description..."></textarea>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success" onclick="addArticle();"><i
                                                    class="fas fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lieu">Lieu</label>
                            <input type="lieu" id="lieu" name="lieu" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ date('Y-m-d') }}" required>
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

        function addArticle() {
            const tbody = document.querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML =
                `<td width="100%">
                    <input type="text" class="col-md-6 form-control form-control-sm mb-3" name="articles[body][${articleIndex}][section]"
                        placeholder="Section" required>
                    <textarea type="text" class="form-control editor-simple" name="articles[body][${articleIndex}][description]" placeholder="Description..."></textarea>
                </td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeArticle(this)"><i class="fas fa-trash"></i></button></td>`;
            tbody.appendChild(newRow);

            articleIndex++;
            editorSimple();
        }

        function removeArticle(button) {
            button.closest('tr').remove();
        }
    </script>
@endsection
