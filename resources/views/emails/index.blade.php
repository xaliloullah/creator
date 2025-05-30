<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de votre adresse email</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family: 'Roboto', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #c0c0c0;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            border: 0.2px solid #c0c0c0;
        }

        .header {
            background: linear-gradient(45deg, #3498db, #34495e);
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .logo {
            width: 50px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header a {
            text-decoration: none;
            color: #ffffff;
        }

        .content a {
            text-decoration: none;
            color: #ffffff;
        }

        .content {
            padding: 30px;
            background: #ffffff;

        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 20px;
        }

        p {
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(45deg, #3498db, #34495e);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            transition: background 0.4s ease, color 0.4s ease;
        }

        .btn:hover {
            background: linear-gradient(45deg, #436e98, #2980b9);
            color: #f0f0f0;
            opacity: 70%;
        }

        .footer {
            background: linear-gradient(45deg, #3498db, #34495e);
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 14px;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                width: 100%;
            }

            .header h1 {
                font-size: 20px;
            }

            .content {
                padding: 20px;
            }

            h2 {
                font-size: 18px;
            }

            .btn {
                display: block;
                width: 100%;
            }

            .text-center {
                text-align: center;
            }
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1><a href="{{ config('app.url') }}">
                    {{-- <img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo"> --}}
                    {{ config('app.name') }}
                </a>
            </h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>

</html>
