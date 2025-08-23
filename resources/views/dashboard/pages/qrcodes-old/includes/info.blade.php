<div class="row">
    <div class="form-group col-lg-12">
        <label class="form-label" for="image">Image</label>
        <div class="image-preview">
            <input class="d-none" name="image" id="image" type="file" />
            <img src="{{ asset('assets/images/' . (auth()->user()->image ? 'users/' . auth()->user()->image : 'default.png')) }}"
                alt="img" id="preview-image" />

            <label for="image" class="btn btn-sm btn-secondary btn-edit" id="btn-edit">
                <i class="fa fa-edit"></i>
            </label>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="content">Contenu :</label>
        <input class="form-control" id="content" name="content" type="text" placeholder="content" value="{{ $qrcode->content }}" required>
    </div> 
    <div class="form-group col-lg-6">
        <label class="form-label" for="type">Type :</label>
        <select id="type" class="form-control" name="type">
            <option value="url">url</option>
            <option value="texte">texte</option>
        </select>
    </div> 
</div>
