<div>
    @foreach ($discussions as $discussion)
        <li class="nav-item">
            {{-- wire:click="set_discussion('{{ $discussion->id }}')" --}}
            <a href="{{ route('discussions.show', $discussion->id) }}"
                class="nav-link menu py-2 d-flex align-items-center justify-content-between @if ($discussion_active && $discussion->id == $discussion_active->id ?? '') active @endif">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('storage/images/' . $discussion->Image()) }}" alt="profil"
                        class="image-preview rounded-circle img-xs img-square m-1 shadow-lg" />

                    <span class="d-flex flex-column ms-2">
                        @if ($discussion->type == 'MP')
                            <span>
                                {{ $discussion->Membre()->prenom ?? '' }}
                                {{ $discussion->Membre()->nom ?? '' }}
                            </span>
                        @else
                            <span>{{ $discussion->designation ?? '' }}</span>
                        @endif
                        <span class="fs-9 mt-1">
                            {!! Str::limit($discussion->Messages->last()->contenu ?? '', 30) !!}
                        </span>
                    </span>
                </span>
                @if ($discussion->Messages()->UnRead()->count() > 0)
                    <span class="badge bg-danger text-white-emphasis fs-9">
                        {{ $discussion->Messages()->UnRead()->count() }}
                    </span>
                @endif
                {{-- <div wire:loading>
                    Loading...
                </div> --}}
            </a>
        </li>
    @endforeach
</div>
