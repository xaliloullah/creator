<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4 border-left-danger">
            <a href="#delete-account" class="d-block card-header py-3" data-toggle="collapse" role="button"
                aria-expanded="false" aria-controls="delete-account">
                <h6 class="m-0 font-weight-bold text-danger text-uppercase"><i class="fa fa-trash mr-3"></i>Supprimer le
                    compte</h6>
            </a>
            <div class="collapse" id="delete-account">
                <div class="card-body">
                    <p>Une fois votre compte supprimé, toutes ses ressources et données seront définitivement
                        supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou
                        informations que vous souhaitez conserver.</p>
                    <a href="#!" data-toggle="modal" data-target="#delete-account-modal"
                        class="btn btn-danger text-right"><i class="fa fa-trash"></i> Supprimer mon compte</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-account-modal" tabindex="-1" role="dialog"
    aria-labelledby="delete-account-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="delete-account-modal-label">Supprimer le compte</h5>
                <a href="#!" class="fas fa-times" data-dismiss="modal" aria-label="Close"></a>
            </div>
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center">
                    <h5>Êtes-vous sûr de vouloir supprimer votre compte ?</h5>
                    <p class="text-700 lh-lg mb-0 mt-3">
                        Une fois votre compte supprimé, toutes ses ressources et données seront définitivement
                        supprimées.
                        Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement
                        votre
                        compte.
                    </p>

                    <div class="form-group">
                        <input class="form-control" id="password" name="password" type="password"
                            placeholder="Mot de passe" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="button" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-danger" type="submit">Supprimer le compte</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section> --}}
