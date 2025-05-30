<!DOCTYPE html>
<html lang="fr">
@php
    $parametre = $facture->parametre;
    $articles = $facture->articles;
    $entreprise = json_decode($facture->User->entreprise ?? '{}', true);
    $THT = array_sum(array_column($articles['body'] ?? [], 'montant')) ?? 0;
    $TVA = $facture->tva ? $THT * ($facture->tva / 100) : 0;
    $TTC = $THT + $TVA;

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
    <title>{{ $facture->numero }}</title>
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
            margin-bottom: 10px;
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
            box-shadow: 1px 6px 12px 2px var(--shadow);
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

        .invoice-details {
            display: flex;
            justify-content: space-between;
        }

        .invoice-info,
        .client-info {
            margin-bottom: 20px;
            max-width: 300px;
        }

        .invoice-title {
            text-align: center;
            margin-top: 20px;
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
        <h1 class="invoice-title">{{ $facture->titre }}</h1>
        <div class="invoice-details">
            <div class="client-info">
                <p><strong>À :</strong> {{ $facture->Client->prenom ?? '' }} {{ $facture->Client->nom ?? '' }}</p>
                <p><strong>Entreprise:</strong> {{ $facture->Client->entreprise ?? '' }}</p>
                @php
                    $adresse = json_decode($facture->Client->adresse, true);
                @endphp
                <p><strong>Adresse:</strong> {{ $adresse['rue'] ?? '' }}
                    {{ $adresse['complement'] ?? '' }}, {{ $adresse['code_postal'] ?? '' }}
                    {{ $adresse['ville'] ?? '' }}
                    {{ $adresse['pays'] ?? '' }} </p>
                <p><strong>Email:</strong> {{ $facture->Client->email ?? '' }}</p>
                <p><strong>Téléphone:</strong>
                    @foreach (json_decode($facture->Client->telephones, true) ?? [] as $telephone)
                        {{ $telephone }}
                    @endforeach
                </p>
            </div>
            <div class="invoice-info">
                <p><strong>Numéro:</strong> {{ $facture->numero }}</p>
                <p><strong>Date:</strong> {{ formatDate($facture->date_emission) }}</p>
                @if ($facture->date_echeance)
                    <p><strong>Echeance:</strong> {{ formatDate($facture->date_echeance) }}</p>
                @endif
            </div>
        </div>
        <table class="card">
            <thead>
                <tr>
                    @foreach ($articles['head'] as $head)
                        <th>{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($articles['body'] as $rows)
                    <tr>
                        @foreach ($rows as $index => $row)
                            <td>
                                {!! $row !!}
                                @if ($index == 'montant')
                                    {{ $facture->devise }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="{{ count($articles['head']) - 1 }}">Total HT</td>
                    <td>{{ $THT }} {{ $facture->devise }}</td>
                </tr>
                @if ($facture->tva)
                    <tr class="total-row">
                        <td colspan="{{ count($articles['head']) - 1 }}">TVA ({{ $facture->tva }}%)</td>
                        <td>{{ $TVA }} {{ $facture->devise }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="{{ count($articles['head']) - 1 }}">Total TTC</td>
                        <td>{{ $TTC }} {{ $facture->devise }}</td>
                    </tr>
                @endif
            </tfoot>
        </table>
        @if ($facture->conditions)
            <div class="conditions">
                <strong>{{ $parametre['titre-conditions'] ?? 'Conditions' }}</strong>
                <p>{!! $facture->conditions !!}</p>
            </div>
        @endif
        <div class="card card-footer">
            {{ $parametre['message'] ?? '' }}
        </div>
    </div>
    <div class="nav fixed-bottom">
        <a onclick="window.print()" class="btn btn-primary no-print" title="imprimer"><i class="fa fa-print"></i></a>
    </div>
</body>

</html>
