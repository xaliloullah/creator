@extends('dashboard.modules.chats.index')
@section('title', 'Chats')
@section('title', 'Discussions')
@section('title2', 'Nouveau')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajouter une nouvelle discussion</h1>
            <p class="text-muted mb-0">
                Remplissez le formulaire ci-dessous pour ajouter un nouvel utilisateur à l'application.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="" class="btn btn-outline-dark">
                <i class="bi bi-list-ul"></i><span class="d-none d-sm-inline ms-2">Liste</span>
            </a>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs nav-fill" id="parametre" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="discussions-amis-tab" data-bs-toggle="tab"
                        data-bs-target="#discussions-amis" type="button" role="tab" aria-controls="discussions-amis"
                        aria-selected="true">Amis</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="discussions-group-tab" data-bs-toggle="tab"
                        data-bs-target="#discussions-group" type="button" role="tab" aria-controls="discussions-group"
                        aria-selected="true">Groupes</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="roles-permissions-tab" data-bs-toggle="tab"
                        data-bs-target="#roles-permissions" type="button" role="tab" aria-controls="roles-permissions"
                        aria-selected="true">Roles &
                        Permissions</button>
                </li> --}}
            </ul>
            <div class="tab-content" id="components-content">
                <div class="tab-pane fade show active" id="discussions-amis" role="tabpanel"
                    aria-labelledby="discussions-amis-tab" tabindex="0">
                    <form action="{{ route('discussions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}" hidden>
                        <input type="hidden" name="type" id="type" value="MP" hidden>
                        <div class="card border-0 shadow-sm mt-3 mb-4">
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <h5 class="mb-3">Amis</h5>
                                    <div class="row g-3">
                                        <select class="form-control" name="membres[]" id="" required>
                                            <option value="" disabled selected>Amis</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-ghost shadow-lg sticky-bottom">
                            <div class="card-body p-3">
                                <div class="d-flex gap-2 float-end">
                                    <button type="reset" class="btn btn-outline-danger">
                                        <i class="bi bi-x-circle me-1"></i>Annuler
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-pencil me-1"></i>Modifier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="discussions-group" role="tabpanel" aria-labelledby="discussions-group-tab"
                    tabindex="0">
                    <form action="{{ route('discussions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}" hidden>
                        <input type="hidden" name="type" id="type" value="GROUP" hidden>

                        <div class="card border-0 shadow-sm mb-4 mt-4">
                            <div class="card-body p-4">
                                <div class="mt-4">
                                    <h5 class="mb-3">Creer un group</h5>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Désignation <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="designation" name="designation"
                                                placeholder="designation" value="{{ old('designation') }}" required />
                                        </div>
                                        <div class="col-md-12">
                                            <label for="membres" class="form-label">Membres</label>
                                            <select class="form-control tags-option" name="membres[]" id="membres"
                                                multiple required>
                                                <option value="" disabled selected>Membres</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->prenom }}
                                                        {{ $user->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-ghost shadow-lg sticky-bottom">
                            <div class="card-body p-3">
                                <div class="d-flex gap-2 float-end">
                                    <button type="reset" class="btn btn-outline-danger">
                                        <i class="bi bi-x-circle me-1"></i>Annuler
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-pencil me-1"></i>Modifier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Side Panel -->
    </div>

    {{-- @push('scripts')
        <script src="{{ asset('assets/js/password.js') }}"></script>
    @endpush --}}
@endsection
