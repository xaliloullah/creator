<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3">Informations générales</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="prenom" name="prenom"
                        value="{{ old('prenom', $resume->prenom) }}" placeholder="Prénom" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nom </label>
                    <input type="text" class="form-control" id="nom" name="nom"
                        value="{{ old('nom', $resume->nom) }}" placeholder="Nom" />
                </div>
                <div class="col-md-12">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="email"
                            value="{{ old('email', $resume->email) }}" />
                        <span class="input-group-text">@</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre"
                        value="{{ old('titre', $resume->titre) }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Organisation</label>
                    <input type="text" class="form-control" id="organisation" name="organisation"
                        placeholder="Organisation" value="{{ old('organisation', $resume->organisation) }}" />
                </div>
                <div class="col-md-12">
                    <label class="form-label">Telephones</label>
                    <select class="form-select tags" multiple name="telephones[]">
                        @foreach ($resume->telephones as $telephone)
                            <option value="{{ $telephone }}" selected>{{ $telephone }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="mb-3">Informations supplémentaires</h5>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Statut : </label>
                    {{-- @component('components.tags', ['badges' => $statuts])
                    @endcomponent --}}
                    {{-- @foreach ($statuts as $statut)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="statut"
                                id="statut-{{ $statut->value }}" value="{{ $statut->value }}"
                                @if (old('statut', $resume->statut->value) == $statut->value) checked @endif required />
                            <label class="form-check-label badge bg-{{ $statut->color }}"
                                for="statut-{{ $statut->value }}">{{ $statut->name }}</label>
                        </div>
                    @endforeach --}}
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control editor" id="description" name="description" placeholder="Description">{{ $resume->description }}</textarea>
                </div>
                {{-- <div class="col-12">
                    <label class="form-label">Condition</label>
                    <select class="form-select tags" multiple name="condition[]">
                        @foreach (json_decode($resume->condition, true) ?? [] as $tag)
                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="col-12">
                    <label class="form-label">Tags</label>
                    <select class="form-select tags" multiple name="tags[]">
                        @foreach ($resume->tags as $tag)
                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Site Web</label>
                    <select class="form-select tags" multiple name="site_web[]">
                        @foreach ($resume->site_web as $site_web)
                            <option value="{{ $site_web }}" selected>{{ $site_web }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
