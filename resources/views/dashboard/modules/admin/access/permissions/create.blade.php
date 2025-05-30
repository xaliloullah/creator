<form action="{{ route('permissions.create') }}" method="POST" class="validate">
    @csrf
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body p-4 row">
            <h5 class="mb-3">Informations du Permissions</h5>
            <div class="col-md-6 mb-1">
                <label class="form-label">Permissions <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name') }}"
                    required />
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Désignation <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="designation" value="{{ old('designation') }}"
                    required />
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
