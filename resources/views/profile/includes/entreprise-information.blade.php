<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-5 border-left-warning">
            <a href="#entreprise-information" class="d-block card-header py-3" data-toggle="collapse" role="button"
                aria-expanded="false" aria-controls="entreprise-information">
                <h6 class="m-0 font-weight-bold text-warning text-uppercase"><i
                        class="fa fa-building mr-3"></i>Informations sur l'entreprise</h6>
            </a>
            <div class="collapse" id="entreprise-information">
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update.settings') }}" class="mt-6 space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label" for="logo">Logo</label>
                                <div class="image-preview">
                                    <input class="d-none" name="logo" id="logo" type="file" />
                                    @if (json_decode($user->entreprise ?? '{}', true)['logo'] ?? null)
                                        <img class="logo"
                                            src="{{ asset('assets/images/logo/' . json_decode($user->entreprise ?? '{}', true)['logo']) }}"
                                            alt="logo" id="preview-logo">
                                    @else
                                        <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="logo"
                                            id="preview-logo">
                                    @endif
                                    <label for="logo" class="btn btn-sm btn-secondary btn-edit" id="btn-edit">
                                        <i class="fa fa-edit"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-lg-8">
                                <label class="form-label" for="entreprise">Nom de l'entreprise</label>
                                <input class="form-control form-control-sm" id="entreprise" name="entreprise[nom]"
                                    type="text"
                                    value="{{ json_decode($user->entreprise ?? '{}', true)['nom'] ?? 'CREATORS' }}"
                                    required>
                                <label class="form-label" for="slogan">Slogan</label>
                                <textarea class="form-control form-control-sm" id="slogan" name="entreprise[slogan]">{{ json_decode($user->entreprise ?? '{}', true)['slogan'] ?? '' }}</textarea>
                                <label class="form-label" for="email">email</label>
                                <input class="form-control form-control-sm" id="email" name="entreprise[email]"
                                    value="{{ json_decode($user->entreprise ?? '{}', true)['email'] ?? $user->email }}">
                                <label class="form-label" for="adresse">Adresse</label>
                                <input class="form-control form-control-sm" id="adresse" name="entreprise[adresse]"
                                    value="{{ json_decode($user->entreprise ?? '{}', true)['adresse'] ?? '' }}">
                            </div>

                        </div>
                        <div class="col-lg-12 text-right mt-3">
                            <button class="btn btn-outline-secondary" type="submit">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
