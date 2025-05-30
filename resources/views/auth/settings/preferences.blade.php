<h3 class="mb-4">Préférences</h3>
<ul class="list-group list-group-flush">
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <div class="fw-bold">Thème</div>
            Choissez votre theme preferer
        </div>
        <div class="dropdown">
            <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                @foreach ([['color' => 'light', 'icon' => 'bi-sun', 'label' => 'Clair'], ['color' => 'dark', 'icon' => 'bi-moon', 'label' => 'Sombre']] as $theme)
                    <li>
                        <a class="dropdown-item" href="#" onclick="setTheme('{{ $theme['color'] }}');">
                            <i class="bi {{ $theme['icon'] }} me-2"></i>{{ $theme['label'] }}
                        </a>
                    </li>
                @endforeach
                <li>{{ session('theme') }}</li>
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
                        <a class="dropdown-item @if ((auth()->user()->parametre['lang'] ?? 'fr') == $lang) active @endif"
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
            <div class="fw-bold">Devise</div>
            Choisissez votre devise préférée
        </div>
        <div class="dropdown">
            <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown"
                aria-label="Sélectionner une devise">
                <i class="bi bi-three-dots"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                @foreach (['XOF' => 'Franc CFA', 'USD' => 'Dollar', 'EUR' => 'Euro', 'GBP' => 'Livre', 'JPY' => 'Yen', 'CNY' => 'Yuan'] as $devise => $name)
                    <li>
                        <a class="dropdown-item @if (auth()->user()->parametre['devise'] == $devise) active @endif
"
                            href="{{ route('profile.settings', ['devise' => $devise]) }}">
                            {{ $name }}
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


{{-- <ul class="list-group list-group-flush">
    <li class="list-group-item d-flex justify-content-between mb-3">
        <div>
            <h6><i class="bi bi-palette me-2"></i>Thème</h6>
        </div>
        <div>
            <div class="dropdown">
                <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="#" onclick="setTheme('light');"><i
                                class="bi bi-sun me-2"></i>Clair</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="setTheme('dark');"><i
                                class="bi bi-moon me-2"></i>Sombre</a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <li class="list-group-item d-flex justify-content-between mb-3">
        <div>
            <h6><i class="bi bi-translate me-2"></i>Langue</h6>
        </div>
        <div>

        </div>
    </li>

    <li class="list-group-item">A fourth item</li>
    <li class="list-group-item">And a fifth one</li>
</ul> --}}
