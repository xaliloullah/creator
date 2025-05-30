<div class="modal fade" id="logout-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Deconnexion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle text-warning fs-1"></i>
                    <h4 class="mt-3">Êtes-vous sûr ?</h4>
                    <p class="text-muted">Sélectionnez « Se déconnecter » ci-dessous si vous êtes prêt à mettre fin à
                        votre
                        session en cours.</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Se déconnecter</button>
                </form>
            </div>
        </div>
    </div>
</div>
