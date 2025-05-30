@extends('dashboard.index')
@section('title', 'emails')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">
                Ajouter une email
                <a href="{{ route('emails.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('emails.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="form-label" for="titre">Titre</label>
                        <input class="form-control" id="titre" name="data[titre]" type="text" placeholder="titre"
                            required>
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="form-label" for="subject">subject</label>
                        <input class="form-control" id="subject" name="subject" type="text" placeholder="subject">
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
