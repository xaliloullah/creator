<!DOCTYPE html>
<html lang="fr">
@php
    $parametre = json_decode($resume->parametre, true);
    $adresse = json_decode($resume->adresse, true);
    $primary = $parametre['primary'] ?? '#3498db';
    $secondary = $parametre['secondary'] ?? '#454545';
    $body = $parametre['body'] ?? '#787878';
    $card = $parametre['card'] ?? '#EDEDED';
    $light = $primary . '33';
    $dark = $secondary . 'b0';
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <title>CV - {{ $resume->prenom }} {{ $resume->nom }}</title>
    <style>
        :root {
            --shadow: rgba(0, 0, 0, 0.3);
            --white: #fff;
            --black: #000;
            --primary: {{ $primary }};
            --secondary: {{ $secondary }};
            --body: {{ $body }};
            --card: {{ $card }};
            --light: {{ $light }};
            --dark: {{ $dark }};
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 3px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d3d3d3;
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
            cursor: all-scroll;
        }

        html {
            scroll-behavior: smooth;
            background: var(--body);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0 auto;
            min-height: 100vh;
            font-size: 14px;
            color: var(--secondary);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            margin-bottom: 10px;
        }

        h1,
        h2,
        h3,
        h4 {
            text-transform: uppercase;
        }

        .sidebar {
            width: 260px;
            background-color: var(--primary);
            padding: 20px;
            min-height: 100vh;
            box-shadow: 5px 6px 12px var(--shadow);
        }

        .sidebar h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            flex: 1;
        }


        .card {
            background-color: var(--card);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 1px 6px 12px 2px var(--shadow);
            max-width: 100%;
            margin-bottom: 20px;
        }

        .card-body {
            margin-top: 10px;
        }

        .fixed-bottom {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .card-title {
            font-size: 1.2em;
            font-weight: bold;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 5px;
        }

        .card-title i {
            margin-right: 10px;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .profile {
            text-align: center;
        }

        .profile-title {
            margin: 10px;
        }

        .profile-item {
            margin: 10px;
        }

        .profile-info {
            text-align: left;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .profile-info h5 {
            margin-bottom: 10px;
        }

        .profile-info a {
            color: var(--secondary);
            text-decoration: none;
            display: block;
        }

        .profile-info a:hover {
            color: var(--dark);
        }

        .profile-info i {
            min-width: 20px;
        }

        .profile-img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border: 5px solid var(--white);
            border-radius: 50%;
        }

        .nav {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
        }

        .nav a {
            /* display: block; */
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: var(--primary);
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 5px 10px;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.35rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
                border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary,
        .btn-secondary {
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--light);
            color: var(--secondary);
        }

        .btn-secondary {
            background-color: var(--dark);
            color: var(--primary);
        }

        .btn:hover {
            box-shadow: 0 4px 8px var(--shadow);
        }

        .btn-primary:hover {
            background-color: var(--primary);
        }

        .btn-secondary:hover {
            background-color: var(--secondary);
        }

        .badge {
            font-size: 0.8em;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 15px;
            background-color: var(--light);
            color: var(--dark);
            display: inline-block;
            margin-bottom: 5px;
            text-decoration: none;
        }

        .badge:hover {
            background-color: var(--primary);
            color: var(--secondary);
        }


        .timeline {
            position: relative;
            border-left: 2px solid var(--primary);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-date {
            font-style: italic;
        }

        .timeline-circle {
            position: absolute;
            left: -6px;
            top: 0;
            width: 10px;
            height: 10px;
            background-color: var(--primary);
            border-radius: 50%;
            border: 2px solid var(--white);
            box-shadow: 0 0 0 4px var(--light);
        }

        .timeline-title {
            color: var(--primary);
        }

        .timeline-content {
            padding-left: 20px;
        }

        .reseaux-sociaux {
            text-align: center;
        }

        .reseaux-sociaux a {
            text-decoration: none;
        }

        .list-style {
            list-style-type: none;
            padding-left: 10px;
            margin: 0;

        }

        .list-style li {
            position: relative;
            padding-left: 25px;
            line-height: 1.5;
            font-size: 12px;
            color: var(--secondary);
            transition: all 0.3s ease;
        }

        .list-style li::before {
            content: '\2022';
            font-size: 24px;
            color: var(--dark);
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .list-item {
            margin-bottom: 10px;
        }

        .progress-bar {
            background-color: var(--white);
            border-radius: 20px;
            overflow: hidden;
            height: 5px;
        }

        .progress {
            background-color: var(--secondary);
            height: 100%;
            border-radius: 20px 0 0 20px;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }

            .content {
                padding: 15px;
            }

            .card {
                padding: 15px;
            }

            .btn {
                padding: 5px 8px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {

            .sidebar {
                width: 200px;
                padding: 15px;
            }

            .content {
                padding: 10px;
            }

            .card {
                padding: 15px;
            }

            .card-title,
            h1,
            h2,
            h3,
            h4 {
                font-size: 1rem;
            }

            .btn {
                padding: 4px 6px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            ::-webkit-scrollbar {
                width: 3px;
                height: 3px;
            }

            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
                padding: 10px;
                box-shadow: none;
                text-align: center;
            }

            .content {
                width: 100%;
                padding: 10px;
            }

            .profile-img {
                width: 100px;
                height: 100px;
            }

            .card {
                padding: 15px;
            }

            .btn {
                padding: 5px 10px;
            }

            .list-style li {
                padding-left: 20px;
                font-size: 10px;
            }
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body id="body">

    <div class="sidebar">
        <div class="profile">
            @if ($resume->image)
                <img src="{{ asset('storage/images/resumes/' . $resume->image) }}" class="profile-img" alt="profile">
            @endif
            <h3 class="profile-title">{{ $resume->prenom }} {{ $resume->nom }}</h3>
            <h5 class="profile-item">{{ $resume->titre }}</h5>
        </div>
        <div class="">{!! $resume->description !!}</div>
        <div class="profile-info">
            @if ($resume->telephones)
                <h5><i class="fa fa-phone"></i>Telephone
                    @foreach (json_decode($resume->telephones, true) as $telephone)
                        <a href="tel:{{ $telephone }}">{{ $telephone }}</a>
                    @endforeach
                </h5>
            @endif
            <h5><i class="fa fa-envelope"></i>Email<a href="mailto:{{ $resume->email }}">{{ $resume->email }}</a>
            </h5>
            @if (is_array($adresse))
                <h5><i class="fa fa-map-marker"></i>Adresse<a
                        href="{{ 'https://www.google.com/maps/place/' . $adresse['ville'] ?? ('' . '+' . $adresse['rue'] ?? '') }}"
                        target="_blank">{{ $adresse['rue'] ?? '' }} {{ $adresse['complement'] ?? '' }}
                        {{ $adresse['code_postal'] ?? '' }} {{ $adresse['ville'] ?? '' }}
                        {{ $adresse['pays'] ?? '' }}</a></h5>
            @endif
        </div>
        <div class="reseaux-sociaux">
            @foreach ($reseaux_sociauxs = json_decode($resume->reseaux_sociaux, true) ?? [] as $reseaux_sociaux)
                <a href="{{ $reseaux_sociaux['url'] }}" title="{{ $reseaux_sociaux['name'] }}" target="_blank">
                    <span class="btn btn-secondary"><i class="fab fa-{{ $reseaux_sociaux['icon'] }}"></i></span>
                </a>
            @endforeach
        </div>
        @if ($resume->langues && is_array($langues = json_decode($resume->langues, true)))
            <div class="profile-info">
                <h5><i class="fa fa-language"></i>{{ $parametre['langue'] ?? 'Langues' }}</h5>
                <ul class="list-style">
                    @foreach ($langues as $langue)
                        <li class="list-item"><strong>{{ $langue['langue'] ?? '' }}</strong> :
                            <div class="progress-bar">
                                <div class="progress" style="width: {{ $langue['niveau'] ?? 0 }}%;"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($resume->interets && is_array($interets = json_decode($resume->interets, true)))
            <div class="profile-info">
                <h5><i class="fa fa-heart"></i>{{ $parametre['interet'] ?? 'Interets' }}</h5>
                @foreach ($interets as $interet)
                    <ul class="list-style">
                        <li><strong>{{ $interet['interet'] ?? '' }}</strong>
                        </li>
                    </ul>
                @endforeach
            </div>
        @endif
        @if ($resume->permis)
            <div class="profile-info">
                <h5><i class="fa fa-car"></i>{{ $parametre['permis'] ?? 'Permis' }}</h5>
                <p>
                    @foreach (json_decode($resume->permis, true) ?? [] as $permi)
                        <small>{{ $permi }}</small>
                    @endforeach
                </p>
            </div>
        @endif
        @if ($resume->liens)
            <div class="profile-info">
                {{-- <h5><i class="fa fa-car"></i>{{ $parametre['liens'] ?? 'liens' }}</h5> --}}
                @foreach (json_decode($resume->liens, true) ?? [] as $lien)
                    <a href="{{ $lien['url'] }}" target="_blank"><small>{{ $lien['nom'] }}</small></a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="content">
        @if ($resume->experiences)
            <div id="experiences" class="card">
                <h4 class="card-title"><i
                        class="fa fa-briefcase"></i>{{ $parametre['experience'] ?? 'Expérience Professionnelle' }}</h4>
                <div class="card-body">
                    <div class="timeline">
                        @if (is_array($experiences = json_decode($resume->experiences, true)))
                            @foreach ($experiences as $experience)
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
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if ($resume->formations)
            <div id="formations" class="card">
                <h4 class="card-title"><i
                        class="fa fa-graduation-cap"></i>{{ $parametre['formation'] ?? 'Formations' }}</h4>
                <div class="card-body">
                    <div class="timeline">
                        @if (is_array($formations = json_decode($resume->formations, true)))
                            @foreach ($formations as $formation)
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
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if ($resume->competences)
            <div id="competences" class="card">
                <h4 class="card-title"><i class="fa fa-book"></i>{{ $parametre['competence'] ?? 'Compétences' }}
                </h4>
                <div class="card-body">
                    @if (is_array($competences = json_decode($resume->competences, true)))
                        @foreach ($competences as $competence)
                            <div class="card-body">
                                <h5 class=""> {{ $competence['titre'] }}</h5>
                                @foreach ($competence['competence'] as $item)
                                    <a href="{{ 'https://www.google.com/search?q=' . $item }}" class="badge"
                                        target="_blank">{{ $item }}</a>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
        @if ($resume->certifications)
            <div id="certifications" class="card">
                <h4 class="card-title"><i
                        class="fa fa-graduation-cap"></i>{{ $parametre['certification'] ?? 'Certifications' }}</h4>
                <div class="card-body">
                    <div class="">
                        @if (is_array($certifications = json_decode($resume->certifications, true)))
                            @foreach ($certifications as $certification)
                                <div class="timeline-content">
                                    <p>
                                        <strong class="timeline-title">{{ $certification['nom'] ?? '' }}</strong>,
                                        <span>{{ $certification['organisme'] ?? '' }}</span>, <span
                                            class="timeline-date">{{ $certification['dates'] ?? '' }}</span>
                                    </p>

                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="nav fixed-bottom">
        <a onclick="window.print()" class="btn btn-primary no-print" title="imprimer"><i class="fa fa-print"></i></a>
    </div>
</body>

</html>
