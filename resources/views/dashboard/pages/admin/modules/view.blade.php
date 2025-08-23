@extends('dashboard.index')
@section('title', 'modules')
@section('title2', 'Détails')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Détails du module</h1>
            <p class="text-muted mb-0">Visualisez les informations complètes du module sélectionné.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('modules.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i> <span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
            <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline ms-2">Modifier</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Informations générales -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Informations générales</h5>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Désignation</dt>
                        <dd class="col-sm-8">{{ $module->designation }}</dd>

                        <dt class="col-sm-4">Nom</dt>
                        <dd class="col-sm-8">{{ $module->name }}</dd>

                        <dt class="col-sm-4">Route</dt>
                        <dd class="col-sm-8">{{ $module->route ?? '—' }}</dd>

                        <dt class="col-sm-4">Lien</dt>
                        <dd class="col-sm-8">
                            @if($module->link)
                                <a href="{{ $module->link }}" target="{{ $module->target ?? '_self' }}">
                                    {{ $module->link }}
                                </a>
                            @else
                                —
                            @endif
                        </dd>

                        <dt class="col-sm-4">Module parent</dt>
                        <dd class="col-sm-8">{{ $module->parent?->designation ?? 'Aucun' }}</dd>

                        <dt class="col-sm-4">Icône</dt>
                        <dd class="col-sm-8">
                            @if($module->icon)
                                <i class="bi {{ $module->icon }} fs-4"></i> ({{ $module->icon }})
                            @else
                                —
                            @endif
                        </dd>

                        <dt class="col-sm-4">Verrouillé</dt>
                        <dd class="col-sm-8">
                            {!! $module->lock ? '<span class="badge bg-danger">Oui</span>' : '<span class="badge bg-success">Non</span>' !!}
                        </dd>

                        <dt class="col-sm-4">Caché</dt>
                        <dd class="col-sm-8">
                            {!! $module->hidden ? '<span class="badge bg-warning text-dark">Oui</span>' : '<span class="badge bg-success">Non</span>' !!}
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Styles -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Styles</h5>
                    <p>
                        @if($module->color)
                            <span class="badge bg-{{ $module->color }}">{{ $module->color }}</span>
                        @else
                            —
                        @endif
                    </p>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Informations supplémentaires</h5>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Statut</dt>
                        <dd class="col-sm-8">
                            @if($module->statut)
                                @php
                                    $statut = $statuts->firstWhere('value', $module->statut);
                                @endphp
                                @if($statut)
                                    <span class="badge bg-{{ $statut->color }}">{{ $statut->name }}</span>
                                @else
                                    {{ $module->statut }}
                                @endif
                            @else
                                —
                            @endif
                        </dd>

                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{!! $module->description ?? '<em>Aucune</em>' !!}</dd>

                        <dt class="col-sm-4">Tags</dt>
                        <dd class="col-sm-8">
                            @if($module->tags && count($module->tags) > 0)
                                @foreach($module->tags as $tag)
                                    <span class="badge bg-secondary">{{ $tag }}</span>
                                @endforeach
                            @else
                                —
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Colonne aide -->
        <div class="col-lg-4">
            <div class="card card-ghost shadow-lg sticky-top">
                <div class="card-body p-4">
                    <h5 class="mb-3">Aide</h5>
                    <div class="alert alert-info mb-0">
                        <h6 class="alert-heading">
                            <i class="bi bi-info-circle me-2"></i>Conseils
                        </h6>
                        <ul class="mt-2 mb-0 ps-3">
                            <li>Vérifiez bien toutes les informations avant modification.</li>
                            <li>Utilisez le bouton "Modifier" pour mettre à jour ce module.</li>
                            <li>En cas de problème, contactez l'administrateur du système.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
