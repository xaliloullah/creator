<!DOCTYPE html>
<html lang="fr">
@php
    $parametre = json_decode($email->parametre ?? '{}', true);
    $data = json_decode($email->data ?? '{}', true);
    $primary = $parametre['primary'] ?? '#3498db';
    $secondary = $parametre['secondary'] ?? '#454545';
    $body = $parametre['body'] ?? '#F3F2F0';
    $card = $parametre['card'] ?? '#FFFFFF';
    $light = $primary . '33';
    $dark = $secondary . 'b0';
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <title>{{ $data['titre'] ?? '' }}</title>
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
            box-shadow: 0.5px 1px 4px 1px var(--shadow);
            max-width: 100%;
            margin-bottom: 20px;
        }

        .card-body {
            margin-top: 0px;
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
            text-align: left;
        }

        .nav a {
            display: block;
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

        .profile-btn {
            text-align: center;
        }

        .profile-btn a {
            text-decoration: none;
        }

        .reseaux-sociaux {
            text-align: left;
        }

        .reseaux-sociaux a {
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            color: var(--secondary);
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
            color: var(--light);
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
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

    <div class="content">
        <div id="contact" class="card">
            <div class="card-body">
                {!! $data['message'] ?? '' !!}
            </div>
        </div>
    </div>
</body>

</html>
