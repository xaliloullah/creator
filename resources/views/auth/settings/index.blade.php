<div class="d-flex align-items-start">
    <div class="w-50 nav flex-column nav-pills me-3 sticky-top align-items-start" id="v-pills-tab" role="tablist"
        aria-orientation="vertical">
        @admin
            <button class="nav-link menu" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button"
                role="tab" aria-controls="general" aria-selected="false"><i
                    class="bi bi-gear-wide-connected me-2"></i>Général</button>
        @endadmin
        <button class="nav-link menu active" id="account-tab" data-bs-toggle="pill" data-bs-target="#account"
            type="button" role="tab" aria-controls="account" aria-selected="true"><i
                class="bi bi-person-circle me-2"></i>Compte</button>
        <button class="nav-link menu" id="preferences-tab" data-bs-toggle="pill" data-bs-target="#preferences"
            type="button" role="tab" aria-controls="preferences" aria-selected="false"><i
                class="bi bi-sliders me-2"></i>Préférences</button>
        <button class="nav-link menu" id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button"
            role="tab" aria-controls="security" aria-selected="false"><i
                class="bi bi-shield-lock me-2"></i>Sécurité</button>
        <button class="nav-link menu" id="support-tab" data-bs-toggle="pill" data-bs-target="#support" type="button"
            role="tab" aria-controls="support" aria-selected="false"><i class="bi bi-question-circle me-2"></i>Aide
            et
            support</button>
    </div>
    <div class="tab-content vh-100 vw-100" id="v-pills-tabContent">
        <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
            @include('auth.settings.general')
        </div>
        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab"
            tabindex="0">
            @include('auth.settings.account')
        </div>
        <div class="tab-pane fade" id="preferences" role="tabpanel" aria-labelledby="preferences-tab" tabindex="0">
            @include('auth.settings.preferences')
        </div>
        <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab" tabindex="0">
            @include('auth.settings.security')
        </div>
        <div class="tab-pane fade" id="support" role="tabpanel" aria-labelledby="support-tab" tabindex="0">
            @include('auth.settings.support')
        </div>
    </div>
</div>
