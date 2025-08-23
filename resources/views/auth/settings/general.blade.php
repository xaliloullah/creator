<h3 class="mb-4">Paramètres Généraux</h3>
<ul class="list-group list-group-flush">
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <div class="fw-bold">Mode</div>
            Choissez le mode de l'application
        </div>
        <div class="dropdown">
            <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                @foreach (['maintenance' => 'Maintenance', 'production' => 'Production', 'development' => 'Développement', 'demo' => 'Démo'] as $key => $mode)
                    <li>
                        <a class="dropdown-item @if (settings('mode') == $key) active @endif"
                            href="{{ route('settings.update', ['mode' => $key]) }}">
                            {{ $mode }}
                        </a>
                    </li>
                @endforeach
            </ul>

        </div>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <div class="fw-bold">Langue</div>
            Choisissez votre langue préférée
        </div>
        <div class="dropdown">
            <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown" id="dropdown-lang">
                <i class="bi bi-three-dots"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                @foreach (['fr' => 'Français', 'en' => 'English', 'es' => 'Español', 'de' => 'Deutsch', 'it' => 'Italiano'] as $lang => $langue)
                    <li>
                        <a class="dropdown-item @if (auth()->user()->parametre['lang'] == $lang) active @endif"
                            href="{{ route('profile.settings', ['lang' => $lang]) }}">
                            <img src="{{ asset('assets/images/flags/' . $lang . '.jpg') }}" class="img-xxs me-2"
                                alt="">{{ $langue }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <div class="fw-bold">Devise de l'application</div>
            Gerer la devise de l'application
        </div>
        <div class="dropdown">
            <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown"
                aria-label="Sélectionner une devise">
                <i class="bi bi-three-dots"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item" href="{{ route('settings.update', ['devise' => settings('devise')]) }}">
                        Mettres a jour
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                @foreach (['XOF' => 'Franc CFA', 'USD' => 'Dollar', 'EUR' => 'Euro', 'GBP' => 'Livre', 'JPY' => 'Yen', 'CNY' => 'Yuan'] as $key => $devise)
                    <li>
                        <a class="dropdown-item @if (settings('devise') == $key) active @endif"
                            href="{{ route('settings.update', ['devise' => $key]) }}">
                            {{ $devise }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <div class="fw-bold">
                <label class="form-check-label" for="notifications">Activer les
                    notifications</label>
            </div>
            {{-- Content for list item --}}
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="notifications">
        </div>
    </li>
</ul>
