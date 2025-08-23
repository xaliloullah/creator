<div class="card border-0 shadow-sm @if ($tarif->parametre['popular'] ?? false) shadow-lg @endif">
    <div class="card-header bg-{{ $tarif->parametre['color'] }} bg-gradient shadow">
        <div class="text-center">
            <h4 class="mb-2 text-uppercase">{{ $tarif->designation }}</h4>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="text-center mb-4">
            @if ($tarif->parametre['popular'] ?? false)
                @component('components.tags', ['tag' => 'populaire', 'color' => $tarif->parametre['color']])
                @endcomponent
            @endif
            <h2 class="display-5 fw-bold mb-0">{{ $tarif->prix->format() }} {{ $tarif->prix->rate->symbol }}</h2>
            <p class="text-muted">/mois</p>
        </div>
        <div class="text-center">
            {!! $tarif->description !!}
        </div>
        <ul class="list-unstyled mb-4">
            @foreach ($tarif->roles as $role)
                <li class="mb-3 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <span>{{ $role }}</span>
                </li>
            @endforeach
            @foreach ($tarif->permissions as $permission)
                <li class="mb-3 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <span>{{ $permission }}</span>
                </li>
            @endforeach
        </ul>
        <div class="text-center">
            @component('components.tags', ['tags' => $tarif->tags, 'color' => $tarif->parametre['color'] ?? ''])
            @endcomponent
        </div>
    </div>
</div>
