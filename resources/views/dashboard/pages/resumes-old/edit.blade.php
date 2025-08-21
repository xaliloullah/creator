@extends('dashboard.index')
@section('title', 'Resumes')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <h6 class="font-weight-bold text-dark">
                Modifier un resume
                <a href="{{ route('resumes.index') }}" class="float-right btn btn-sm btn-secondary btn-icon-split">
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
                    <form action="{{ route('resumes.update', $resume->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div id="accordionResumes" class="accordion custom-scrollbar p-3">
                            <div class="card shadow">
                                <a href="#collapse-apparence" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapse-apparence">
                                    <h6 class="m-0 font-weight-bold text-dark">Apparence</h6>
                                </a>
                                <div class="collapse show" id="collapse-apparence" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.apparence')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-profil" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-profil">
                                    <h6 class="m-0 font-weight-bold text-dark">Profil </h6>
                                </a>
                                <div class="collapse" id="collapse-profil" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.profil')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-experiences" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-experiences">
                                    <input type="text" name="parametre[experience]"
                                        class="form-control-plaintext m-0 font-weight-bold text-dark"
                                        value="{{ json_decode($resume->parametre, true)['experience'] ?? 'Expérience Professionnelle' }}">
                                </a>
                                <div class="collapse" id="collapse-experiences" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.experiences')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-formations" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-formations">
                                    <input type="text" name="parametre[formation]"
                                        class="form-control-plaintext m-0 font-weight-bold text-dark"
                                        value="{{ json_decode($resume->parametre, true)['formation'] ?? 'Formations' }}">
                                </a>
                                <div class="collapse" id="collapse-formations" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.formations')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-competences" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-competences">
                                    <input type="text" name="parametre[competence]"
                                        class="form-control-plaintext m-0 font-weight-bold text-dark"
                                        value="{{ json_decode($resume->parametre, true)['competence'] ?? 'Compétences' }}">
                                </a>
                                <div class="collapse" id="collapse-competences" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.competences')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-langues" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-langues">
                                    <input type="text" name="parametre[langue]"
                                        class="form-control-plaintext m-0 font-weight-bold text-dark"
                                        value="{{ json_decode($resume->parametre, true)['langue'] ?? 'Langues' }}">
                                </a>
                                <div class="collapse" id="collapse-langues" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.langues')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-certifications" class="d-block card-header py-3"
                                    data-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="collapse-certifications">
                                    <input type="text" name="parametre[certification]"
                                        class="form-control-plaintext m-0 font-weight-bold text-dark"
                                        value="{{ json_decode($resume->parametre, true)['certification'] ?? 'Certifications' }}">
                                </a>
                                <div class="collapse" id="collapse-certifications" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.certifications')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-interets" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-interets">
                                    <input type="text" name="parametre[interet]"
                                        class="form-control-plaintext m-0 font-weight-bold text-dark"
                                        value="{{ json_decode($resume->parametre, true)['interet'] ?? 'Interets' }}">
                                </a>
                                <div class="collapse" id="collapse-interets" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.interets')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-liens" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-liens">
                                    <input type="text" name="parametre[lien]"
                                        class="form-control-plaintext m-0 font-weight-bold text-dark"
                                        value="{{ json_decode($resume->parametre, true)['lien'] ?? 'Liens' }}">
                                </a>
                                <div class="collapse" id="collapse-liens" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.liens')
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow">
                                <a href="#collapse-reseaux_sociaux" class="d-block card-header py-3"
                                    data-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="collapse-reseaux_sociaux">
                                    <input type="text" name="parametre[reseaux_sociaux]"
                                        class="form-control-plaintext m-0 font-weight-bold text-dark"
                                        value="{{ json_decode($resume->parametre, true)['reseaux_sociaux'] ?? 'Resaux Sociaux' }}">
                                </a>
                                <div class="collapse" id="collapse-reseaux_sociaux" data-parent="#accordionResumes">
                                    <div class="card-body">
                                        @include('dashboard.pages.resumes.includes.reseaux_sociaux')
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
                        <a href="{{ route('resumes.show', crypter($resume->id)) }}" class="float-right text-dark"
                            target="_blank"><i class="fa fa-eye"></i></a>
                        <div class="text-dark">Aperçu</div>
                    </div>
                    <iframe class="card" src="{{ route('resumes.show', crypter($resume->id)) }}" height="400px"
                        width="100%" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
