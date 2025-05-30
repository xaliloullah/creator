<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page Translation Example</title>

    <!-- Intégration de Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body>.skiptranslate {
            display: none !important;
        }

        body {
            top: 0px !important;
        }
    </style>
    <script type="text/javascript" src="{{ asset('assets/js/translate/translate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/translate/init.js') }}"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Welcome to my page</h1>

        <!-- Dropdown Bootstrap pour sélectionner la langue -->
        <div class="dropdown text-center mb-3">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown-lang" data-bs-toggle="dropdown"
                aria-expanded="false">Language
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-lang">
                @foreach (['en' => 'English', 'fr' => 'Français', 'es' => 'Español', 'de' => 'Deutsch', 'it' => 'Italiano'] as $index => $lang)
                    <li>
                        <a class="dropdown-item" href="#"
                            onclick="changeLanguage('{{ $index }}')">
                            <img src="{{ asset('assets/images/flags/' . $index . '.jpg') }}" class="w-25"
                                alt=""> {{ $lang }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Div pour le widget Google Translate (invisible) -->
        <div id="translator" style="display: none"></div>

        <!-- Contenu de la page -->
        <p class="lead text-center">
            This is an example of page translation. You can translate the
            page content into another language using the dropdown above.
        </p>

        <div class="d-flex justify-content-center">
            <button class="btn btn-primary">Example Button</button>
        </div>
    </div>

    <!-- Intégration de Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
