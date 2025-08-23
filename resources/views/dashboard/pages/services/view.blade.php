@php
    $primary = $service->parametre['primary'] ?? '#4e73df';
    $secondary = $service->parametre['secondary'] ?? '#858796';
    $background = $service->parametre['background'] ?? '#f8f9fc';
    $foreground = $service->parametre['foreground'] ?? '#ffffff';
@endphp

{{-- <style>
    :root {
        --bs-primary: {{ $primary }};
        --bs-danger: {{ $secondary }}
    }
</style> --}}
{{-- <!DOCTYPE html>
<html lang="fr">
@section('title', 'service')
@include('dashboard.includes.head')

<style>
    span {
        color: {{ $primary }}
    }

    .btn {
        color: {{ $foreground }};
    }
</style>

<body style="background: {{ $background }};">
    <div class="card bg-gradient mb-4 shadow-lg" style="background: {{ $primary }}; color:{{ $primary }}">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center gap-3">
                <div class="">
                    <img src="{{ asset('assets/images/' . $service->image()) }}" alt="Image"
                        class="mx-auto rounded-circle img-lg img-square shadow" />
                </div>
                <h1 class="h3 fw-bolder" style="color:{{ $secondary }};">{{ $service->prenom }} {{ $service->nom }}
                </h1>
                <div style="color:{{ $foreground }}">
                    <p class="mb-0">{!! $service->description !!}
                    </p>
                </div>
                <div class=""><a href="mailto:{{ $service->email }}" class="btn shadow"
                        style="background: {{ $secondary }};"><i class="bi bi-envelope-fill"></i></a>
                    <a href="{{ 'https://www.google.com/maps/place/...' }}" target="_blank" class="btn shadow"
                        style="background: {{ $secondary }};"><i class="bi bi-geo-alt-fill"></i></a>
                    <a href="" class="btn shadow" style="background: {{ $secondary }};"><i
                            class="bi bi-telephone-plus-fill"></i></a>
                </div>
            </div>
        </div>
    </div>


    <div class="card mb-4 border-0 shadow" style="background: {{ $foreground }}; color:{{ $secondary }}">
        <div class="card-body">
            <h2 class="h5"><i class="bi bi-telephone-fill me-3"></i>Contact
            </h2>
            <ul class="list-style" style="color: {{ $primary }}">
                <li><i class="bi bi-envelope-fill me-3"></i><a
                        href="mailto:{{ $service->email }}"><span>{{ $service->email }}</span></a></li>
                @foreach ($service->telephones as $telephone)
                    <li><i class="bi bi-phone-fill me-3"></i><a
                            href="tel:{{ $telephone }}"><span>{{ $telephone }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @if ($service->reseaux_sociaux)
        <div id="reseaux_sociaux" class="card mb-4 border-0 shadow"
            style="background: {{ $foreground }}; color:{{ $secondary }}">
            <div class="card-body row g-3">
                <h2 class="h5"><i class="bi bi-phone-fill me-3"></i>Resaux
                    Sociaux
                </h2>
                @foreach ($service->reseaux_sociaux as $reseaux_sociaux)
                    <a href="{{ $reseaux_sociaux['url'] ?? '' }}" title="{{ $reseaux_sociaux['icon'] ?? '' }}"
                        target="_blank">
                        <span class="btn" style="background: {{ $primary }}"><i
                                class="bi bi-{{ $reseaux_sociaux['icon'] ?? '' }}"></i></span>
                        <span style="color: {{ $primary }}" class="fw-bold">{{ $reseaux_sociaux['name'] ?? '' }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    <div class="card mb-4 border-0 shadow-lg" style="background: {{ $foreground }}; color:{{ $secondary }}">
        <div class="card-body">
            <h2 class="h5"><i class="bi bi-globe me-3"></i>Site Web</h2>
            <ul class="list-style">
                @foreach ($service->site_web as $site_web)
                    <li><a href="{{ $site_web }}" target="_blank"><span>{{ $site_web }}</span></a> </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>

</html> --}}


<!DOCTYPE html>
<html lang="fr"> 
@section('title', $service->designation)
@include('includes.head')

<body>
    @include('dashboard.modules.services.includes.header')

    <div class="container vh-100">
        <div class="content">
            @component('components.alert')
            @endcomponent
            {{-- @yield('content') --}}
        </div>
    </div>
    @include('dashboard.modules.services.includes.footer')
    @include('includes.js')
    @include('dashboard.modules.services.includes.cart')

</body>

</html>
