@extends('dashboard.index')
@section('title', 'Contrats')
@section('content')
    @php
        $parametre = json_decode($contrat->parametre ?? '{}', true);
        $articles = json_decode($contrat->articles ?? '{}', true);
    @endphp
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Modifier un contrat
                <a href="{{ route('contrats.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
                <a href="{{ route('contrats.show', crypter($contrat->id)) }}" target="_blank"
                    class="float-right btn btn-sm btn-info btn-icon-split mr-3">
                    <span class="icon text-white-50">
                        <i class="fas fa-eye"></i>
                    </span>
                    <span class="text">Consulter</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('contrats.update', $contrat->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titre">Titre</label>
                            <input type="text" class="form-control text-uppercase" id="titre" name="titre"
                            value="{{ $contrat->titre }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select class="form-control" id="client_id" name="client_id" required>
                                <option value="" selected disabled>Choisir un Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" @if ($client->id == $contrat->client_id) selected @endif>
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
                                    @foreach ($articles['body'] as $index => $article)
                                        <tr>
                                            <td width="100%">
                                                <input type="text" class="col-md-6 form-control form-control-sm mb-3"
                                                    name="articles[body][{{ $index }}][section]"
                                                    placeholder="Section" value="{{ $article['section'] }}" required>
                                                <textarea type="text" class="form-control editor-simple" name="articles[body][{{ $index }}][description]"
                                                    placeholder="Description...">{!! $article['description'] !!}</textarea>
                                            </td>
                                            <td>
                                                @if ($loop->first)
                                                    <button type="button" class="btn btn-success"
                                                        onclick="addArticle();"><i class="fas fa-plus"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeArticle(this)"><i class="fas fa-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lieu">Lieu</label>
                            <input type="lieu" id="lieu" name="lieu" class="form-control" value="{{$contrat->lieu}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ $contrat->date }}" required>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="reset" class="btn btn-danger">Annuler</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        let articleIndex = {{ count($articles['body']) }};

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
