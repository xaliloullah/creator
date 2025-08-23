@extends('layouts.website') {{-- Layout public frontend --}}

@section('content')
<div class="container py-5" style="background: {{ $website->parametre['background'] ?? '#f8f9fc' }}; color: {{ $website->parametre['foreground'] ?? '#000' }}">
    <div class="text-center mb-4">
        @if($website->logo)
            <img src="{{ asset('storage/'.$website->logo) }}" alt="Logo" class="mb-3" style="max-height:100px;">
        @endif
        <h1>{{ $website->designation }}</h1>
        <p>{{ $website->description }}</p>
    </div>

    @if($website->telephones)
        <div class="mb-3">
            <h5>Téléphones</h5>
            <ul>@foreach($website->telephones as $tel)<li>{{ $tel }}</li>@endforeach</ul>
        </div>
    @endif

    @if($website->adresse)
        <div class="mb-3">
            <h5>Adresse</h5>
            <p>{{ $website->adresse['rue'] ?? '' }}, {{ $website->adresse['ville'] ?? '' }} {{ $website->adresse['code_postal'] ?? '' }}, {{ $website->adresse['pays'] ?? '' }}</p>
        </div>
    @endif

    @if($website->reseaux_sociaux)
        <div class="mb-3">
            <h5>Réseaux sociaux</h5>
            @foreach($website->reseaux_sociaux as $rs)
                <a href="{{ $rs['url'] }}" target="_blank" class="btn btn-dark btn-sm m-1">
                    <i class="bi bi-{{ $rs['icon'] }}"></i> {{ $rs['name'] }}
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
