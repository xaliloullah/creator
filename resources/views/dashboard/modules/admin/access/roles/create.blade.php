<form action="{{ route('roles.create') }}" method="POST" class="validate">
    @csrf
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body p-4 row">
            <h5 class="mb-3">Informations du Rôle</h5>
            <div class="col-md-6 mb-1">
                <label class="form-label">Rôle <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name') }}"
                    required />
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Designation <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="designation" value="{{ old('designation') }}"
                    required />
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Permissions</label>
                <select class="form-select tags" multiple name="permissions[]">
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->name }}" @if (in_array($permission->name, old('permissions', []))) selected @endif>
                            {{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label mb-3" for="color">Couleur</label>
                <div class="form-group">
                    <label for="color-picker" class="form-label visually-hidden">Couleur</label>
                    <div id="color-picker" class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                        @foreach ($colors as $color)
                            <input type="radio" class="btn-check" name="color" id="{{ $color->value }}"
                                value="{{ $color->value }}" autocomplete="off"
                                @if (old('color') == $color->value) checked @endif />
                            <label
                                class="color-option bg-{{ $color->value }} @if (old('color') == $color->value) active @endif"
                                for="{{ $color->value }}" title="{{ $color->name }}"></label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label mb-3" for="icon">Icon</label>
                <div class="form-group text-center">
                    @foreach ($icons as $icon)
                        <input type="radio" class="btn-check" name="icon" id="{{ $icon }}"
                            value="{{ $icon }}" @if (old('icon') == $icon) checked @endif
                            autocomplete="off">
                        <label class="btn btn-outline-dark mb-1 @if (old('icon') == $icon) active @endif"
                            for="{{ $icon }}">
                            <i class="bi {{ $icon }} fs-4"></i>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body p-4">
            <div class="mb-4">
                <h5 class="mb-3">Informations supplémentaires</h5>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control editor" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>

                    </div>
                    <div class="col-12">
                        <label class="form-label">Tags</label>
                        <select class="form-select tags" multiple name="tags[]">
                            @foreach (old('tags', []) as $tags)
                                <option value="{{ $tags }}" selected>{{ $tags }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-ghost mt-3 mb-3 shadow-lg sticky-bottom">
        <div class="card-body p-3">
            <div class="d-flex gap-2 float-end">
                <button type="reset" class="btn btn-outline-danger">
                    <i class="bi bi-x-circle me-1"></i>Annuler
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i>Ajouter
                </button>
            </div>
        </div>
    </div>
</form>
