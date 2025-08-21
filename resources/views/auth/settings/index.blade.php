<div class="row">
    {{-- Navigation --}}
    <div class="col-12 col-md-3 mb-3 mb-md-0 sticky-top bg-light">
        <div class="nav nav-pills flex-row justify-content-between sticky-top" id="v-pills-tab" role="tablist">

            <button class="nav-link menu active" id="account-tab" data-bs-toggle="pill" data-bs-target="#account"
                type="button" role="tab" aria-controls="account" aria-selected="true">
                <i class="bi bi-person-circle me-2"></i>Compte
            </button>

            @admin
                <button class="nav-link menu" id="general-tab" data-bs-toggle="pill" data-bs-target="#general"
                    type="button" role="tab" aria-controls="general" aria-selected="false">
                    <i class="bi bi-gear-wide-connected me-2"></i>Général
                </button>
            @endadmin

            <button class="nav-link menu" id="preferences-tab" data-bs-toggle="pill" data-bs-target="#preferences"
                type="button" role="tab" aria-controls="preferences" aria-selected="false">
                <i class="bi bi-sliders me-2"></i>Préférences
            </button>

            <button class="nav-link menu" id="security-tab" data-bs-toggle="pill" data-bs-target="#security"
                type="button" role="tab" aria-controls="security" aria-selected="false">
                <i class="bi bi-shield-lock me-2"></i>Sécurité
            </button>

            <button class="nav-link menu" id="support-tab" data-bs-toggle="pill" data-bs-target="#support"
                type="button" role="tab" aria-controls="support" aria-selected="false">
                <i class="bi bi-question-circle me-2"></i>Aide et support
            </button>
        </div>
    </div>

    {{-- Contenu --}}
    <div class="col-12 col-md-9">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                @include('auth.settings.account')
            </div>
            <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                @include('auth.settings.general')
            </div>
            <div class="tab-pane fade" id="preferences" role="tabpanel" aria-labelledby="preferences-tab">
                @include('auth.settings.preferences')
            </div>
            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                @include('auth.settings.security')
            </div>
            <div class="tab-pane fade" id="support" role="tabpanel" aria-labelledby="support-tab">
                @include('auth.settings.support')
            </div>
        </div>
    </div>
</div>
