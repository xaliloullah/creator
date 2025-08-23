@extends('dashboard.index')
@section('title', 'Resumes')
@section('subtitle', 'Modifier')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier un resume</h1>
            <p class="text-muted mb-0">
                Mettez à jour les informations du resume en remplissant le formulaire ci-dessous.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>

        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('resumes.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('resumes.show', $resume->id) }}" class="btn btn-outline-dark" target="_blank">
                <i class="bi bi-eye"></i><span class="d-none d-sm-inline ms-2">Consulter</span>
            </a>
            <a href="{{ route('resumes.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('resumes.update', $resume->id) }}" method="POST" enctype="multipart/form-data" class="validate">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">

                @include('dashboard.pages.resumes.includes.profil')
                @include('dashboard.pages.resumes.includes.styles')
                @include('dashboard.pages.resumes.includes.experiences')
                @include('dashboard.pages.resumes.includes.formations')
                @include('dashboard.pages.resumes.includes.certifications')
                @include('dashboard.pages.resumes.includes.competences')
                @include('dashboard.pages.resumes.includes.langues')
                @include('dashboard.pages.resumes.includes.reseaux_sociaux')
                @include('dashboard.pages.resumes.includes.interets')
                @include('dashboard.pages.resumes.includes.liens')

                <div class="card card-ghost shadow-lg sticky-bottom">
                    <div class="card-body p-3">
                        <div class="d-flex gap-2 float-end">
                            <button type="reset" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-1"></i>Modifier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-none d-sm-block">
                <div class="card rounded-4 shadow-lg overflow-hidden mobile-size sticky-top">
                    <div class="card-header text-center shadow">Aperçu</div>
                    <iframe src="{{ route('resumes.show', $resume->id) }}" class="w-100 h-100 border-0"></iframe>
                </div>

                {{-- <div class="card shadow-lg sticky-top overflow-hidden rounded-4 h-25">
                    <div class="card-header ">Aperçu</div>
                    
                </div> --}}

                {{-- <div class="card card-ghost shadow-lg">
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
                </div> --}}
            </div>
        </div>
    </form>
@endsection
