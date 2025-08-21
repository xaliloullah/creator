<!DOCTYPE html>
<html lang="fr">
@php
    $primary = $resume->parametre['primary'] ?? '#4e73df';
    $secondary = $resume->parametre['secondary'] ?? '#858796';
    $background = $resume->parametre['background'] ?? '#f8f9fc';
    $foreground = $resume->parametre['foreground'] ?? '#ffffff';
@endphp
@section('title', "CV - $resume->prenom $resume->nom")
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
    {{-- <div class="card bg-gradient mb-4 shadow-lg" style="background: {{ $primary }}; color:{{ $primary }}">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center gap-3">
                <div class="">
                    <img src="{{ asset('assets/images/' . $resume->image()) }}" alt="Image"
                        class="mx-auto rounded-circle img-lg img-square shadow" />
                </div>
                <h1 class="h3 fw-bolder" style="color:{{ $secondary }};">{{ $resume->prenom }} {{ $resume->nom }}
                </h1>
                <div style="color:{{ $foreground }}">
                    {{ $resume->titre }}
                    <p class="mb-0">{!! $resume->description !!}
                    </p>
                </div>
                <div class=""><a href="mailto:{{ $resume->email }}" class="btn shadow"
                        style="background: {{ $secondary }};"><i class="bi bi-envelope-fill"></i></a>
                    <a href="{{ 'https://www.google.com/maps/place/...' }}" target="_blank" class="btn shadow"
                        style="background: {{ $secondary }};"><i class="bi bi-geo-alt-fill"></i></a>
                    <a href="" class="btn shadow" style="background: {{ $secondary }};"><i
                            class="bi bi-telephone-plus-fill"></i></a>
                </div>
                @if ($resume->langues)
                    <div class="profile-info">
                        <h5><i class="bi bi-language"></i>{{ $resume->parametre['langue'] }}</h5>
                        <ul class="list-style">
                            @foreach ($resume->langues as $langue)
                                <li class="list-item"><strong>{{ $langue['langue'] ?? '' }}</strong> :
                                    <div class="progress-bar">
                                        <div class="progress" style="width: {{ $langue['niveau'] ?? 0 }}%;"></div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if ($resume->interets)
                    <div class="profile-info">
                        <h5><i class="bi bi-heart"></i>{{ $resume->parametre['interet'] ?? '' }}</h5>
                        @foreach ($resume->interets as $interet)
                            <ul class="list-style">
                                <li><strong>{{ $interet['interet'] ?? '' }}</strong>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                @endif
                @if ($resume->permis)
                    <div class="profile-info">
                        <h5><i class="bi bi-car"></i>{{ $resume->parametre['permis'] ?? '' }}</h5>
                        <p>
                            @foreach ($resume->permis as $permi)
                                <small>{{ $permi }}</small>
                            @endforeach
                        </p>
                    </div>
                @endif
                @if ($resume->liens)
                    <div class="profile-info"> 
                        @foreach (json_decode($resume->liens, true) ?? [] as $lien)
                            <a href="{{ $lien['url'] }}" target="_blank"><small>{{ $lien['nom'] }}</small></a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div class="card mb-4 border-0 shadow" style="background: {{ $foreground }}; color:{{ $secondary }}">
        <div class="card-body">
            <h2 class="h5"><i class="bi bi-telephone-fill me-3"></i>Contact
            </h2>
            <ul class="list-style" style="color: {{ $primary }}">
                <li><i class="bi bi-envelope-fill me-3"></i><a
                        href="mailto:{{ $resume->email }}"><span>{{ $resume->email }}</span></a></li>
                @foreach ($resume->telephones as $telephone)
                    <li><i class="bi bi-phone-fill me-3"></i><a
                            href="tel:{{ $telephone }}"><span>{{ $telephone }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @if ($resume->reseaux_sociaux)
        <div id="reseaux_sociaux" class="card mb-4 border-0 shadow"
            style="background: {{ $foreground }}; color:{{ $secondary }}">
            <div class="card-body row g-3">
                <h2 class="h5"><i class="bi bi-phone-fill me-3"></i>Resaux
                    Sociaux
                </h2>
                @foreach ($resume->reseaux_sociaux as $reseaux_sociaux)
                    <a href="{{ $reseaux_sociaux['url'] }}" title="{{ $reseaux_sociaux['icon'] }}" target="_blank">
                        <span class="btn" style="background: {{ $primary }}"><i
                                class="bi bi-{{ $reseaux_sociaux['icon'] }}"></i></span>
                        <span style="color: {{ $primary }}" class="fw-bold">{{ $reseaux_sociaux['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @if ($resume->experiences)
        <div id="experiences" class="card">
            <h4 class="card-title"><i class="bi bi-briefcase"></i>{{ $resume->parametre['experience'] }}
            </h4>
            <div class="card-body">
                <div class="timeline">
                    @foreach ($resume->experiences as $experience)
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">{{ $experience['poste'] ?? '' }}</h4>
                                <p><strong>{{ $experience['entreprise'] ?? '' }}</strong> | <span
                                        class="timeline-date">{{ $experience['dates'] ?? '' }}</span></p>
                                <p>{!! $experience['description'] ?? '' !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if ($resume->formations)
        <div id="formations" class="card">
            <h4 class="card-title"><i class="bi bi-graduation-cap"></i>{{ $resume->parametre['formation'] }}
            </h4>
            <div class="card-body">
                <div class="timeline">
                    @foreach ($resume->formations as $formation)
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <div class="timeline-content">
                                <p>
                                    <strong class="timeline-title">{{ $formation['diplome'] ?? '' }}</strong> |
                                    <span>{{ $formation['etablissement'] ?? '' }}</span> | <span
                                        class="timeline-date">{{ $formation['dates'] ?? '' }}</span>
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if ($resume->competences)
        <div id="competences" class="card">
            <h4 class="card-title"><i class="bi bi-book"></i>{{ $resume->parametre['competence'] }}
            </h4>
            <div class="card-body">
                @foreach ($resume->competences as $competence)
                    <div class="card-body">
                        <h5 class=""> {{ $competence['titre'] }}</h5>
                        @foreach ($competence['competence'] as $item)
                            <a href="{{ 'https://www.google.com/search?q=' . $item }}" class="badge"
                                style="background: {{ $primary }}; color:{{ $secondary }}"
                                target="_blank">{{ $item }}</a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @if ($resume->certifications)
        <div id="certifications" class="card">
            <h4 class="card-title"><i class="bi bi-graduation-cap"></i>{{ $resume->parametre['certification'] }}</h4>
            <div class="card-body">
                <div class="">
                    @foreach ($resume->certifications as $certification)
                        <div class="timeline-content">
                            <p>
                                <strong class="timeline-title">{{ $certification['nom'] ?? '' }}</strong>,
                                <span>{{ $certification['organisme'] ?? '' }}</span>, <span
                                    class="timeline-date">{{ $certification['dates'] ?? '' }}</span>
                            </p>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="card mb-4 border-0 shadow-lg" style="background: {{ $foreground }}; color:{{ $secondary }}">
        <div class="card-body">
            <h2 class="h5"><i class="bi bi-globe me-3"></i>Site Web</h2>
            <ul class="list-style">
                @foreach ($resume->site_web as $site_web)
                    <li><a href="{{ $site_web }}" target="_blank"><span>{{ $site_web }}</span></a> </li>
                @endforeach
            </ul>
        </div>
    </div> --}}
    <div class="m-3">
        <div class="row shadow-lg rounded">
            <!-- Colonne de gauche (Informations personnelles) -->
            <div class="col-md-4 card bg-gradient shadow-lg border-0 text-center"
                style="background: {{ $primary }}; color:{{ $primary }}">
                <img src="https://via.placeholder.com/150" class="rounded-circle img-fluid mb-3" alt="Photo de profil">
                <h2 class="fw-bold">Nom Prénom</h2>
                <p class="fs-5">Développeur Web Full Stack</p>
                <hr class="border-light">

                <p><i class="bi bi-envelope-fill"></i> contact@email.com</p>
                <p><i class="bi bi-telephone-fill"></i> +33 6 12 34 56 78</p>
                <p><i class="bi bi-geo-alt-fill"></i> 123 Rue Exemple, Paris</p>

                <div class="d-flex justify-content-center mt-3">
                    <a href="#" class="btn btn-light btn-sm me-2"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="btn btn-light btn-sm"><i class="bi bi-github"></i></a>
                </div>

                <a href="#" class="btn btn-outline-light mt-4">Télécharger le CV</a>
            </div>

            <!-- Colonne de droite (Expérience & Compétences) -->
            <div class="col-md-8 card border-0 shadow"
                style="background: {{ $foreground }}; color:{{ $secondary }}">
                <h3 class="text-primary">Expérience Professionnelle</h3>
                <div class="border-start border-primary ps-3 mb-4">
                    <h5>Développeur Web - Entreprise X</h5>
                    <p class="text-muted">2022 - Présent</p>
                    <p>Développement d’applications web responsives avec Bootstrap, JavaScript et PHP.</p>
                </div>

                <div class="border-start border-primary ps-3 mb-4">
                    <h5>Stage Développeur - Entreprise Y</h5>
                    <p class="text-muted">2021 - 2022</p>
                    <p>Refonte du site web en Bootstrap 5 et optimisation du référencement.</p>
                </div>

                <h3 class="text-primary">Éducation</h3>
                <div class="border-start border-primary ps-3 mb-4">
                    <h5>Licence Informatique - Université Z</h5>
                    <p class="text-muted">2019 - 2022</p>
                </div>

                <h3 class="text-primary">Compétences</h3>
                <div class="mb-3">
                    <p class="mb-1">HTML & CSS</p>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 90%;">90%</div>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="mb-1">JavaScript & React</p>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 85%;">85%</div>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="mb-1">PHP & MySQL</p>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 80%;">80%</div>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="mb-1">Git & GitHub</p>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 75%;">75%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
