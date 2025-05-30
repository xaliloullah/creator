@extends('dashboard.index')
@section('title', 'qrcodes')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Ajouter une qrcode
                <a href="{{ route('qrcodes.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('qrcodes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="form-label" for="image">Image</label>
                        <div class="image-preview">
                            <input class="d-none" name="image" id="image" type="file" />
                            <img src="{{ asset('assets/images/' . (auth()->user()->image ? 'users/' . auth()->user()->image : 'default.png')) }}"
                                alt="img" id="preview-image" />

                            <label for="image" class="btn btn-sm btn-secondary btn-edit" id="btn-edit">
                                <i class="fa fa-edit"></i>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="form-label" for="content">Contenu :</label>
                        <input class="form-control" id="content" name="content" type="text" placeholder="content"
                            required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="type">Type :</label>
                        <select id="type" class="form-control" name="type">
                            <option value="url">url</option>
                            <option value="texte">texte</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label"for="size">Taille :</label>
                        <input class="form-control" type="number" id="size" name="parametre[size]" min="100"
                            max="500" value="200">
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="margin">Marge :</label>
                        <input class="form-control" type="number" id="margin" name="parametre[margin]" min="0"
                            max="10" value="3">
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="error_correction_level">Niveau de correction d'erreur :</label>
                        <select id="error_correction_level" class="form-control" name="parametre[error_correction_level]">
                            @foreach (['L' => 'Low', 'M' => 'Medium', 'Q' => 'Quartile', 'H' => 'High'] as $index => $ecl)
                                <option value="{{ $index }}" @if (json_decode($qrcode->parametre, true)['error_correction_level'] ?? 'H' == $index) selected @endif>
                                    {{ $ecl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="style">Style :</label>
                        <select id="style" class="form-control" name="parametre[style]">
                            <option value="square">Carré</option>
                            <option value="dot">Dot</option>
                            <option value="round">Rond</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label" for="eye">Forme des yeux:</label>
                        <select id="eye" class="form-control" name="parametre[eye]">
                            <option value="square">Carré</option>
                            <option value="circle">Rond</option>
                        </select>
                    </div>
                </div>
                <div class="text-right">
                    <button type="reset" class="btn btn-danger">Annuler</button>
                    <button type="submit" class="btn btn-success">Continuer</button>
                </div>
            </form>
        </div>
    </div>
@endsection
