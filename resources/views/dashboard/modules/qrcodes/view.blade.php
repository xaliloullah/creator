<!DOCTYPE html>
<html lang="fr">
@php
    $parametre = json_decode($qrcode->parametre, true);
    $primary = $parametre['primary'] ?? '#3498db';
    $secondary = $parametre['secondary'] ?? '#454545';
    $background1 = $parametre['background-1'] ?? '#787878';
    $background2 = $parametre['background-2'] ?? '#EDEDED';
    $light = $primary . '33';
    $dark = $secondary . 'b0';
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <title>qrcode</title>
    <style>
        :root {
            --shadow: rgba(0, 0, 0, 0.3);
            --white: #fff;
            --black: #000;
            --primary: {{ $primary }};
            --secondary: {{ $secondary }};
            --body: {{ $background1 }};
            --card: {{ $background2 }};
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

        .content {
            padding: 20px;
            flex: 1;
            text-align: center;
        }


        .card {
            background-color: var(--card);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 1px 6px 12px 2px var(--shadow);
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
            background-color: var(--secondary);
            color: var(--primary);
        }

        .btn:hover {
            box-shadow: 0 4px 8px var(--shadow);
        }

        .btn-primary:hover {
            background-color: var(--primary);
        }

        .btn-secondary:hover {
            background-color: var(--light);
            color: var(--secondary);
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
        }

        .profile-btn {
            text-align: center;
        }

        .profile-btn a {
            text-decoration: none;
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
                padding: 15px;
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

            .content {
                width: 100%;
                padding: 10px;
            }

            .card {
                padding: 15px;
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
        <div id="QrCode" class="card">
            <h4 class="card-title"><i class="fa fa-qrcode"></i>QrCode</h4>
            <div class="card-body">
                {!! $qrCode !!}
            </div>
        </div>
    </div>
    <div class="nav fixed-bottom">
        <a onclick="window.print()" class="btn btn-primary no-print" title="imprimer"><i class="fa fa-print"></i></a>
    </div>
</body>

</html>
