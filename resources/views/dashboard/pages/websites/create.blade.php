@extends('dashboard.index')
@section('title', 'Websites')
@section('subtitle', 'Créer')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Créer un Website</h1>
        <p class="text-muted mb-0">
            Remplissez le formulaire ci-dessous pour créer un nouveau Website.
            <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ obligatoire.</small>
        </p>
    </div>
    <a href="{{ route('websites.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
    </a>
</div>

<form action="{{ route('websites.store') }}" method="POST" enctype="multipart/form-data" class="validate">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            {{-- Informations générales --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Informations générales</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Désignation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="designation" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="slug" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Thème</label>
                            <input type="text" class="form-control" name="theme" value="default">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <input type="text" class="form-control" name="type">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Logo</label>
                            <input type="file" class="form-control" name="logo" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Favicon</label>
                            <input type="file" class="form-control" name="favicon" accept="image/*">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Contact</label>
                            <textarea class="form-control" name="contact"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Styles --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Styles</h5>
                    @php
                        $colors = ['primary'=>'#4e73df','secondary'=>'#858796','background'=>'#f8f9fc','foreground'=>'#ffffff'];
                    @endphp
                    <div class="row g-3">
                        @foreach($colors as $key => $color)
                            <div class="col-md-6">
                                <label class="form-label">{{ ucfirst($key) }}</label>
                                <div class="input-group color-picker mb-4">
                                    <input type="color" class="color-input color-option shadow border-0" name="parametre[{{ $key }}]" value="{{ $color }}" />
                                    <input type="text" class="color-code form-control form-control-sm" placeholder="{{ $color }}" />
                                    <button type="button" class="color-option color-random btn btn-dark">
                                        <i class="bi bi-shuffle "></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Aperçu & soumission --}}
            <div class="card card-ghost shadow-lg sticky-bottom">
                <div class="card-body p-3">
                    <div class="d-flex gap-2 float-end">
                        <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-circle me-1"></i>Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Créer</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aperçu côté droit --}}
        <div class="col-lg-4 d-none d-sm-block">
            <div class="card shadow-lg sticky-top overflow-hidden rounded-4 mobile-size">
                <div class="card-header text-center shadow">Aperçu</div>
                <iframe src="" class="w-100 h-100 border-0"></iframe>
            </div>
        </div>
    </div>
</form>
@endsection
