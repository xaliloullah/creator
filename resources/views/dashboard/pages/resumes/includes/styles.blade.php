<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row mb-4">
            <h5 class="mb-3">Styles</h5>
            <div class="col-md-6">
                <label class="form-label" for="parametre[primary]">Couleur Primaire</label>
                <div class="input-group color-picker mb-4">
                    <input type="color" class="color-input color-option shadow border-0"
                        value="{{ old('parametre.primary', $resume->parametre['primary'] ?? '#4e73df') }}"
                        id="parametre[primary]" name="parametre[primary]" title="Choisissez votre couleur" />
                    <input type="text" class="color-code form-control form-control-sm" placeholder="e.g. #4e73df" />
                    <button type="button" class="color-option color-random btn btn-dark"
                        title="Choisissez une couleur aléatoire">
                        <i class="bi bi-shuffle "></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="parametre[secondary]">Couleur Secondaire</label>
                <div class="input-group color-picker mb-4">
                    <input type="color" class="color-input color-option shadow border-0"
                        value="{{ old('parametre.secondary', $resume->parametre['secondary'] ?? '#858796') }}"
                        id="parametre[secondary]" name="parametre[secondary]" title="Choisissez votre couleur" />
                    <input type="text" class="color-code form-control form-control-sm" placeholder="e.g. #858796" />
                    <button type="button" class="color-option color-random btn btn-dark"
                        title="Choisissez une couleur aléatoire">
                        <i class="bi bi-shuffle "></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="parametre[background]">Couleur Arrière plan</label>
                <div class="input-group color-picker mb-4">
                    <input type="color" class="color-input color-option shadow border-0"
                        value="{{ old('parametre.background', $resume->parametre['background'] ?? '#f8f9fc') }}"
                        id="parametre[background]" name="parametre[background]" title="Choisissez votre couleur" />
                    <input type="text" class="color-code form-control form-control-sm" placeholder="e.g. #f8f9fc" />
                    <button type="button" class="color-option color-random btn btn-dark"
                        title="Choisissez une couleur aléatoire">
                        <i class="bi bi-shuffle "></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="parametre[foreground]">Couleur Premier plan</label>
                <div class="input-group color-picker mb-4">
                    <input type="color" class="color-input color-option shadow border-0"
                        value="{{ old('parametre.foreground', $resume->parametre['foreground'] ?? '#ffffff') }}"
                        id="parametre[foreground]" name="parametre[foreground]" title="Choisissez votre couleur" />
                    <input type="text" class="color-code form-control form-control-sm" placeholder="e.g. #ffffff" />
                    <button type="button" class="color-option color-random btn btn-dark"
                        title="Choisissez une couleur aléatoire">
                        <i class="bi bi-shuffle "></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
