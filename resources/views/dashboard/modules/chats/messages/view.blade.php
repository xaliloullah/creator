<div id="message{{ $message->id ?? '' }}"
    class="d-flex flex-column @if ($message->user_id == auth()->user()->id) align-items-end @else align-items-start @endif">
    <div class="col-10 col-md-6 d-flex flex-column">
        <div
            class="d-flex @if ($message->user_id == auth()->user()->id) flex-row-reverse align-items-end @else flex-row align-items-start @endif py-2">
            <img src="{{ asset('storage/images/' . $message->User->image()) }}" alt="profil"
                class="image-preview rounded-circle img-xs img-square m-1" />
            <div class="dropdown">
                <div
                    class="card rounded-4 bg-gradient shadow-sm border-0 
                        @if ($message->user_id == auth()->user()->id) bg-primary rounded-bottom-0 rounded-start-4 
                        @else bg-secondary rounded-top-0 rounded-end-4 @endif">
                    <a class="cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="py-2 px-3">
                            @if ($message->Reponse ?? null)
                                <div
                                    class="card-header 
                                @if ($message->user_id == auth()->user()->id) bg-secondary 
                                @else 
                                    bg-primary @endif bg-opacity-25 text-white-emphasis rounded-4 border-2">

                                    {{ $message->Reponse->User->prenom ?? '' }}
                                    {{ $message->Reponse->User->nom ?? '' }}

                                    <div class="fs-9">
                                        {!! Str::limit($message->Reponse->contenu ?? '', 100) !!}
                                    </div>
                                </div>
                            @endif
                            <div class="card-text text-white-emphasis">{!! $message->contenu !!}</div>
                            <div class="text-end">
                                <div
                                    class="d-flex align-items-center justify-content-end gap-1 text-white-emphasis text-muted">
                                    <span class="fs-9">{{ $message->updated_at->format('H:i') }}</span>
                                    <i class="bi bi-check-lg"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        @if ($message->user_id == auth()->user()->id)
                            {{-- <li>
                                <a class="dropdown-item" wire:click.prevent>
                                    <i class="bi bi-pencil-square me-2"></i>Modifier
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" wire:click.prevent>
                                    <i class="bi bi-info-circle me-2"></i>Infos
                                </a>
                            </li> --}}
                            {{-- <li>
                                <hr class="dropdown-divider" />
                            </li> --}}
                            <li>
                                <a class="dropdown-item text-danger" wire:click="delete_message('{{ $message->id }}')">
                                    <i class="bi bi-trash me-2"></i>Supprimer
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item" wire:click="reply_to('{{ $message->id }}')">
                                    <i class="bi bi-reply me-2"></i>Répondre
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>
