<!DOCTYPE html>
<html lang="fr">
@php
    $primary = $vcard->parametre['primary'] ?? '#4e73df';
    $secondary = $vcard->parametre['secondary'] ?? '#858796';
    $background = $vcard->parametre['background'] ?? '#f8f9fc';
    $foreground = $vcard->parametre['foreground'] ?? '#ffffff';
@endphp
@section('title', 'VCard')
@include('includes.head')

<style>
    :root {
        --bs-primary: {{ $primary }};
        --bs-secondary: {{ $secondary }};
        --bs-body-bg: {{ $background }};
        --bs-body-color: {{ $foreground }};
    }

    span {
        color: {{ $primary }}
    }

    .btn {
        color: {{ $foreground }};
    }
</style>

<body style="background: {{ $background }};" class="p-3">
    <div class="card bg-gradient mb-4 shadow-lg" style="background: {{ $primary }}; color:{{ $primary }}">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center gap-3">
                <div class="">
                    <img src="{{ asset('assets/images/' . $vcard->image()) }}" alt="Image"
                        class="mx-auto rounded-circle img-lg img-square shadow" />
                </div>
                <h1 class="h3 fw-bolder" style="color:{{ $secondary }};">{{ $vcard->prenom }} {{ $vcard->nom }}
                </h1>
                <div style="color:{{ $foreground }}">
                    <p class="mb-0">{!! $vcard->description !!}
                    </p>
                </div>
                <div class="">
                    <a href="mailto:{{ $vcard->email }}" class="btn shadow"
                        style="background: {{ $secondary }};"><i class="bi bi-envelope-fill"></i>
                    </a>

                    <a href="https://www.google.com/maps/place/{{ urlencode($vcard->adresse['rue']) }}, {{ urlencode($vcard->adresse['complement']) }}, {{ urlencode($vcard->adresse['ville']) }}, {{ urlencode($vcard->adresse['code_postal']) }}, {{ urlencode($vcard->adresse['pays']) }}"
                        target="_blank" class="btn shadow" style="background: {{ $secondary }};"><i
                            class="bi bi-geo-alt-fill"></i>
                    </a>
                    <a href="tel:{{ $vcard->telephones[0] ?? '' }}" class="btn shadow"
                        style="background: {{ $secondary }};"><i class="bi bi-telephone-fill"></i>
                    </a>
                    <a href="{{ route('vcard.download', $vcard->id) }}" class="btn shadow"
                        style="background: {{ $secondary }};"><i class="bi bi-person-plus-fill"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="card mb-4 border-0 shadow" style="background: {{ $foreground }}; color:{{ $secondary }}">
        <div class="card-body">
            <h2 class="h5"><i class="bi bi-telephone-fill me-3"></i>Contact
            </h2>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="mailto:{{ $vcard->email }}" class="icon-link" style="color:{{ $secondary }}">
                        <i class="bi bi-envelope-fill"></i>
                        <span>{{ $vcard->email }}</span>
                    </a>
                </li>
                @foreach ($vcard->telephones as $telephone)
                    <li class="list-group-item">
                        <a href="tel:{{ $telephone }}" class="icon-link" style="color:{{ $secondary }}">
                            <i class="bi bi-phone-fill"></i>
                            <span>{{ $telephone }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @if ($vcard->reseaux_sociaux)
        <div id="reseaux_sociaux" class="card mb-4 border-0 shadow"
            style="background: {{ $foreground }}; color:{{ $secondary }}">
            <div class="card-body row g-3">
                <h2 class="h5"><i class="bi bi-phone-fill me-3"></i>Resaux
                    Sociaux
                </h2>
                @foreach ($vcard->reseaux_sociaux as $reseaux_sociaux)
                    <a href="{{ $reseaux_sociaux['url'] }}" title="{{ $reseaux_sociaux['icon'] }}" target="_blank">
                        <span class="btn btn-sm" style="background: {{ $primary }}"><i
                                class="bi bi-{{ $reseaux_sociaux['icon'] }}"></i></span>
                        <span style="color: {{ $primary }}" class="fw-bold">{{ $reseaux_sociaux['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    <div class="card mb-4 border-0 shadow" style="background: {{ $foreground }}; color:{{ $secondary }}">
        <div class="card-body">
            <h2 class="h5"><i class="bi bi-globe me-3"></i>Site Web</h2>
            <ul class="list-style">
                @foreach ($vcard->site_web as $site_web)
                    <li><a href="{{ $site_web }}" target="_blank"><span>{{ $site_web }}</span></a> </li>
                @endforeach
            </ul>
        </div>
    </div>
    @include('includes.js')
</body>

</html>
