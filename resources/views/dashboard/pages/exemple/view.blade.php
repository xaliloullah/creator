@extends('admin.index')
@section('title', 'tarifs')
@section('title2', 'Details')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Details du tarif</h1>
            <p class="text-muted mb-0">Afficher les informations complètes sur le tarif</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tarifs.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('tarifs.edit', $tarif->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-pencil"></i><span class="d-none d-sm-inline ms-2">Modifier</span>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Informations générales -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-4">Informations générales</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="small text-muted d-block">Designation</label>
                            <span class="fs-5">{{ $tarif->nom }}</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small text-muted d-block">Prix </label>
                            <span class="fs-5">{{ $tarif->prix }} FCFA</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small text-muted d-block">Reduction</label>
                            <span class="fs-5">{{ $tarif->reduction }} %</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small text-muted d-block">Durée</label>
                            <span class="fs-5">{{ $tarif->duree }} jour(s)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Styles -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-4">Styles</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted d-block">Couleur</label>
                            <span
                                class="badge bg-{{ json_decode($tarif->parametre ?? '{}', true)['color'] }} p-4 rounded-circle">
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-4">Informations supplémentaires</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="small text-muted d-block">Etat</label>

                            @foreach (['actif' => ['success', true], 'inactif' => ['danger', false]] as $index => $etat)
                                @if ($tarif->etat == $etat[1])
                                    <span class="badge bg-{{ $etat[0] }}">{{ $index }}</span>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-12 mb-3">
                            <label class="small text-muted d-block">Description</label>
                            <p class="mb-0">{{ $tarif->description }}</p>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted d-block">Tags</label>
                            <div class="d-flex flex-wrap gap-2">
                                {{ $tarif->tags }}
                                @foreach (json_decode($tarif->tags, true) ?? [] as $tag)
                                    <span class="badge bg-info">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="col-lg-4">
            {{-- <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Tags</h5>
                        {{ $tarif->tags }}
                    </div>
                </div> --}}

            <!-- Informations d'enregistrement -->
            <div class="card border-0 shadow-sm mb-4 sticky-top">
                <div class="card-body p-4">
                    <h5 class="mb-3">Informations d'enregistrement</h5>
                    <h6 class="mb-0">Date de création</h6>
                    <small class="text-muted">{{ $tarif->created_at }}</small>
                    <h6 class="mt-3 mb-0">Date de modification</h6>
                    <small class="text-muted">{{ $tarif->updated_at }}</small>
                    {{--
                    <dl class="row mb-0">
                        <dt class="col-sm-6">Created</dt>
                        <dd class="col-sm-6 text-muted">{{ $tarif->created_at }}</dd>

                        <dt class="col-sm-6">Modified</dt>
                        <dd class="col-sm-6 text-muted">{{ $tarif->updated_at }}</dd>
                    </dl>
                        --}}
                </div>
            </div>

            <!-- Related Products -->
            {{-- <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Related Products</h5>
                        <div class="list-group list-group-flush">
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                                <img src="https://via.placeholder.com/40" alt="" class="rounded">
                                <div>
                                    <h6 class="mb-0">Related Product 1</h6>
                                    <small class="text-muted">$89.99</small>
                                </div>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                                <img src="https://via.placeholder.com/40" alt="" class="rounded">
                                <div>
                                    <h6 class="mb-0">Related Product 2</h6>
                                    <small class="text-muted">$129.99</small>
                                </div>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                                <img src="https://via.placeholder.com/40" alt="" class="rounded">
                                <div>
                                    <h6 class="mb-0">Related Product 3</h6>
                                    <small class="text-muted">$79.99</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div> --}}
        </div>
    </div>
    {{-- <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">
                Details du tarif
                <a href="{{ route('tarifs.index') }}" class="btn btn-sm btn-secondary float-end">
                    <i class="bi bi-arrow-left"></i>
                    <span class="text">Retour</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label class="text-secondary" for="nom">Nom:</label>
                        <span>{{ $tarif->nom }}</span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label class="text-secondary" for="prix">prix:</label>
                        <span>{{ $tarif->prix }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-secondary" for="description">Description:</label>
                        {!! $tarif->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
