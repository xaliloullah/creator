<div class="row">
    <div class="mb-3 col-6">
        <label for="primary" class="form-label">Couleur Primaire</label>
        <input type="color" class="form-control form-control-color" id="primary" name="parametre[primary]"
            value="{{ json_decode($email->parametre, true)['primary'] ?? '#3498db' }}">
    </div>
    <div class="mb-3 col-6">
        <label for="secondary" class="form-label">Couleur Secondaire</label>
        <input type="color" class="form-control form-control-color" id="secondary" name="parametre[secondary]"
            value="{{ json_decode($email->parametre, true)['secondary'] ?? '#454545' }}">
    </div>
    <div class="mb-3 col-6">
        <label for="body" class="form-label">Arrière plan</label>
        <input type="color" class="form-control form-control-color" id="body" name="parametre[body]"
            value="{{ json_decode($email->parametre, true)['body'] ?? '#F3F2F0' }}">
    </div>
    <div class="mb-3 col-6">
        <label for="card" class="form-label">Premier plan</label>
        <input type="color" class="form-control form-control-color" id="card" name="parametre[card]"
            value="{{ json_decode($email->parametre, true)['card'] ?? '#FFFFFF' }}">
    </div>
</div>
