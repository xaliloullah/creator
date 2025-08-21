<!DOCTYPE html>
<html lang="fr">
@php
    $parametre = json_decode($contrat->parametre ?? '{}', true);
    $articles = json_decode($contrat->articles ?? '{}', true);
    $entreprise = json_decode($contrat->User->entreprise ?? '{}', true);
    $signature = json_decode($contrat->signature ?? '{}', true);
    $primary = $parametre['primary'] ?? '#3498db';
    $secondary = $parametre['secondary'] ?? '#454545';
    $body = $parametre['body'] ?? '#eaeaea';
    $card = $parametre['card'] ?? '#EDEDED';
    $light = $primary . '33';
    $dark = $secondary . 'b0';
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <title>{{ $contrat->numero }}</title>
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
            max-width: 794px;
            min-height: 100vh;
            font-size: 14px;
            color: var(--secondary);
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
        }

        header h2 {
            margin-bottom: 0px;
        }

        header p {
            font-size: 10px;
            margin-bottom: 0px;
        }

        a {
            color: var(--primary);
        }

        a:hover {
            color: var(--dark);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
        }

        h1,
        h2,
        h3,
        h4 {
            text-transform: uppercase;

        }

        .content {
            padding: 20px;
            margin: 20px;
            flex: 1;
        }


        .card {
            background-color: var(--card);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 1px 3px 10px 1px var(--shadow);
            max-width: 100%;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-body {
            margin-top: 10px;
            padding: 20px;
        }

        .fixed-bottom {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .card-header {
            font-size: 1.2em;
            font-weight: bold;
            border-top: 2px solid var(--primary);
            background-color: var(--light);
        }

        .card-header i {
            margin-right: 10px;
        }

        .card-footer {
            font-size: 0.8em;
            text-align: center;
            border-bottom: 2px solid var(--primary);
            background-color: var(--light);
            margin-top: 40px;
        }

        .card-footer i {
            margin-right: 10px;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .logo {
            max-width: 60px;
        }

        .signature {
            max-width: 200px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
        }

        .invoice-info,
        .client-info {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .client-info {
            max-width: 300px;
        }

        .client-info h3,
        .invoice-info h3 {
            margin-bottom: 20px;
        }

        .invoice-title {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
            color: var(--primary);
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            padding-left: 20px;
            padding-right: 20px;
            text-align: left;
            border-bottom: 1px solid var(--light);
        }

        th,
        .total-row td {
            white-space: nowrap;
        }

        td:last-child,
        th:last-child {
            text-align: right;
        }

        td:first-child,
        th:first-child {
            width: 100%;
        }

        th {
            background-color: var(--light);
            font-weight: bold;
            color: var(--secondary);
        }

        .total-row {
            font-weight: bold;
            background-color: var(--light);
        }

        .total-row td:first-child {
            text-align: right;
        }

        .conditions {
            padding: 20px;
            margin-top: 40px;
        }

        .nav {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
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

        @media (max-width: 1024px) {
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

            .content {
                padding: 10px;
            }

            .card {
                padding: 15px;
            }

            .card-header,
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

            table {
                display: block;
                overflow-x: auto;
                white-space: normal;
            }

            .content {
                width: 100%;
                padding: 10px;
            }

            .card {
                padding: 15px;
                overflow-x: scroll;
            }

            .btn {
                padding: 5px 10px;
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
    <div class="content">
        <div class="card card-header">
            <header>
                @if ($entreprise['logo'] ?? null)
                    <img src="{{ asset('assets/images/logo/' . $entreprise['logo']) }}" alt="Logo de l'entreprise"
                        class="logo">
                @else
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo de l'entreprise" class="logo">
                @endif
                <div class="">
                    <h2>{{ $entreprise['nom'] ?? '' }}</h2>
                    <p> {{ $entreprise['adresse'] ?? '' }} </p>
                    <p><a href="mailto:{{ $entreprise['email'] ?? '' }}">{{ $entreprise['email'] ?? '' }}</a>
                    </p>
                    <p>
                        @foreach ($entreprise['telephones'] ?? [] as $telephone)
                            <a class="" href="tel:{{ $telephone }}">{{ $telephone }}</a>
                        @endforeach
                    </p>
                </div>
            </header>
        </div>
        <h1 class="invoice-title">{{ $contrat->titre }}</h1>
        <div class="invoice-details">

            <div class="invoice-info">
                <h3>Le Prestataire</h3>
                <p><strong>Numéro:</strong> {{ $contrat->numero }}</p>
                <p><strong>Date:</strong> {{ formatDate($contrat->date) }}</p>
                @if ($contrat->lieu)
                    <p><strong>Lieu:</strong> {{ $contrat->lieu }}</p>
                @endif
            </div>
            <div class="client-info">
                <h3>Le Client</h3>
                <p>{{ $contrat->Client->prenom ?? '' }} {{ $contrat->Client->nom ?? '' }}</p>
                <p><strong>Entreprise:</strong> {{ $contrat->Client->entreprise ?? '' }}</p>
                @php
                    $adresse = json_decode($contrat->Client->adresse, true);
                @endphp
                <p><strong>Adresse:</strong> {{ $adresse['rue'] ?? '' }}
                    {{ $adresse['complement'] ?? '' }}, {{ $adresse['code_postal'] ?? '' }}
                    {{ $adresse['ville'] ?? '' }}
                    {{ $adresse['pays'] ?? '' }} </p>
                <p><strong>Email:</strong> {{ $contrat->Client->email ?? '' }}</p>
                <p><strong>Téléphone:</strong>
                    @foreach (json_decode($contrat->Client->telephones, true) ?? [] as $telephone)
                        {{ $telephone }}
                    @endforeach
                </p>
            </div>
        </div>
        <div class="">
            @foreach ($articles['body'] as $article)
                <div class="invoice-info">
                    <h2>{{ $article['section'] }}</h2>
                    <p>{!! $article['description'] !!}</p>
                </div>
            @endforeach
        </div>
        <div class="invoice-details">
            <div class="invoice-info">
                <p><strong>Fait le:</strong> {{ formatDate($contrat->date) }}</p>
                <p><strong>A:</strong> {{ $contrat->lieu }}</p>
            </div>
        </div>
        <div class="invoice-details">
            <div class="invoice-info">
                <strong>Le Prestataire</strong>

                @if ($entreprise['signature'] ?? null)
                    <p>{{ formatDate($ontrat->date) }}</p>
                    <img src="{{ asset('assets/images/signatures/' . $entreprise['signature']) }}" alt=""
                        class="signature">
                @else
                    <p class="no-print">Date et signature</p>
                @endif
            </div>
            <div class="invoice-info">
                <strong>Le Client</strong>
                @if ($signature['image'] ?? null)
                    <p>{{ formatDate($signature['date']) }}</p>
                    <img src="{{ asset('assets/images/signatures/' . ($signature['image'])) }}" alt=""
                        class="signature">
                    <p class="no-print signature">
                        <input type="checkbox" name="confirme" id="confirme">
                        <label for="confirme">
                            <small>Je confirme que la signature que j'importe est la mienne, et j'accepte
                                qu'elle soit utilisée
                                pour valider ce document conformément à la loi.</small>
                        </label>
                    </p>
                @else
                    <p class="no-print">Date et signature</p>
                @endif
            </div>
        </div>
        <div class="card card-footer">
            <form action="{{ route('contrats.update', $contrat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="client_id" value="{{ $contrat->client_id }}">
                <input type="file" name="image" id="signature" value="true" hidden>
                <button class="btn btn-primary no-print"></button>
            </form>
            <script>
                document.getElementById('signature').addEventListener('change', function() {
                    if (this.files.length > 0) {
                        this.closest('form').submit();
                    }
                });
            </script>
        </div>
    </div>
    <div class="nav fixed-bottom">
        <a onclick="window.print()" class="btn btn-primary no-print" title="imprimer"><i class="fa fa-print"></i></a>
        @if ($contrat->etat)
            <label for="signature" class="btn btn-primary no-print" title="imprimer"><i class="fa fa-upload"></i>
                Importer
                votre signature</label>
        @endif
    </div>
</body>

</html>
