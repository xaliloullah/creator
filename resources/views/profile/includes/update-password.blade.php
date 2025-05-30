<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-5 border-left-secondary">
            <a href="#update-password" class="d-block card-header py-3" data-toggle="collapse" role="button"
                aria-expanded="false" aria-controls="update-password">
                <h6 class="m-0 font-weight-bold text-secondary text-uppercase"><i class="fa fa-key mr-3"></i>Mettre à
                    jour le mot de passe</h6>
            </a>
            <div class="collapse" id="update-password">
                <div class="card-body">
                    <p>Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.
                    </p>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="">
                            <div class="form-group col-lg-12">
                                <label class="form-label" for="update_password_current_password">Mot de passe
                                    actuel</label>
                                <input class="form-control" id="update_password_current_password"
                                    name="current_password" type="password" autocomplete="current-password" required>
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label" for="update_password_password">Nouveau mot de passe</label>
                                <input class="form-control" id="update_password_password" name="password"
                                    type="password" autocomplete="new-password" required>
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label" for="update_password_password_confirmation">Confirmez le mot
                                    de passe</label>
                                <input class="form-control" id="update_password_password_confirmation"
                                    name="password_confirmation" type="password" autocomplete="new-password" required>
                            </div>
                            <div class="col-lg-12 text-right">
                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Saved.') }}</p>
                                @endif
                                <button class="btn btn-outline-secondary" type="submit">Sauvegarder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
