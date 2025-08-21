@extends('dashboard.index')
@section('title', 'qrcodes')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <h6 class="font-weight-bold text-dark">
                Modifier un qrcode
                <a href="{{ route('qrcodes.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-8">
                    <form action="{{ route('qrcodes.update', $qrcode->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="custom-scrollbar p-3">
                            <div class="card shadow">
                                <a href="#collapse-apparence" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapse-apparence">
                                    <h6 class="m-0 font-weight-bold text-dark">Apparence </h6>
                                </a>
                                <div class="collapse show" id="collapse-apparence">
                                    <div class="card-body">
                                        @include('dashboard.pages.qrcodes.includes.apparence')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-info" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-info">
                                    <h6 class="m-0 font-weight-bold text-dark">Information de base</h6>
                                </a>
                                <div class="collapse" id="collapse-info">
                                    <div class="card-body">
                                        @include('dashboard.pages.qrcodes.includes.info')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center m-3">
                            <button type="reset" class="btn btn-danger">Annuler</button>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <div class="col-4">
                    <div class="card-header shadow">
                        <a href="{{ route('qrcodes.show', crypter($qrcode->id)) }}" class="float-right text-dark" target="_blank"><i
                                class="fa fa-eye"></i></a>
                        <div class="text-dark">Aperçu</div>
                    </div>
                    <iframe class="card" src="{{ route('qrcodes.show', crypter($qrcode->id)) }}" height="400px"
                        width="100%" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
