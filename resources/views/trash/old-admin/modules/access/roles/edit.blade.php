@extends('admin.modules.access.edit')
@section('section')
    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="validate">
        @csrf
        @method('PUT')
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body p-4 row">
                <h5 class="mb-3">Informations du Rôle</h5>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom du Rôle <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $role->name }}" required />
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Designation <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="designation" value="{{ $role->designation }}"
                        required />
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Permissions</label>
                    <select class="form-select tags" multiple name="permissions[]">
                        @foreach ($role->permissions as $permission)
                            <option value="{{ $permission->name }}" selected>{{ $permission->name }}</option>
                        @endforeach
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
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
                                    @if (old('color', $role->color) == $color->value) checked @endif />
                                <label
                                    class="color-option bg-{{ $color->value }} @if (old('color', $role->color) == $color->value) active @endif"
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
                                value="{{ $icon }}" autocomplete="off"
                                @if ($role->icon == $icon) checked @endif>
                            <label class="btn btn-outline-dark mb-1" for="{{ $icon }}">
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
                            <textarea class="form-control editor" id="description" name="description" placeholder="Description">{{ $role->description }}</textarea>

                        </div>
                        <div class="col-12">
                            <label class="form-label">Tags</label>
                            <select class="form-select tags" multiple name="tags[]">
                                @foreach ($role->tags as $tag)
                                    <option value="{{ $tag }}" selected>{{ $tag }}</option>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>Modifier
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
