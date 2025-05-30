<h3 class="mb-4">Paramètres de sécurité</h3>
<form>
    <div class="mb-3">
        <label for="currentPassword" class="form-label">Mot de passe actuel</label>
        <input type="password" class="form-control" id="currentPassword" placeholder="Entrez votre mot de passe actuel">
    </div>
    <div class="mb-3">
        <label for="newPassword" class="form-label">Nouveau mot de passe</label>
        <input type="password" class="form-control" id="newPassword" placeholder="Entrez votre nouveau mot de passe">
    </div>
    <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirmer le nouveau mot de
            passe</label>
        <input type="password" class="form-control" id="confirmPassword"
            placeholder="Confirmez votre nouveau mot de passe">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="twoFactor">
        <label class="form-check-label" for="twoFactor">Activer l'authentification à deux
            facteurs</label>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour les paramètres de
        sécurité</button>
</form>
