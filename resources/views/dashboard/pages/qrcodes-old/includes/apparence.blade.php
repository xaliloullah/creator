@php
    $parametre = json_decode($qrcode->parametre, true);
@endphp
<div class="row">
    <div class="mb-3 col-6">
        <label for="color" class="form-label">Couleur </label><label class="float-right" for="toggleGradient"> <input
                type="checkbox" @if ($parametre['gradient-color'] ?? '') checked @endif id="toggleGradient"> Degrader</label>
        <input type="color" class="form-control form-control-color" id="color" name="parametre[color]"
            value="{{ $parametre['color'] ?? '#000000' }}">

        <input type="color" class="form-control form-control-color mt-1"
            @if ($parametre['gradient-color'] ?? false) @else style="display: none;" @endif id="gradient"
            name="parametre[gradient-color]" value="{{ $parametre['gradient-color'] ?? '' }}"
            @if ($parametre['gradient-color'] ?? false) @else disabled @endif>
        <script>
            const toggleGradient = document.getElementById('toggleGradient');
            const gradient = document.getElementById('gradient');
            toggleGradient.addEventListener('change', function() {
                if (toggleGradient.checked) {
                    gradient.style.display = 'block';
                    gradient.disabled = false;
                } else {
                    gradient.style.display = 'none';
                    gradient.disabled = true;
                    gradient.value = '';
                }
            });
        </script>
    </div>
    <div class="mb-3 col-6">
        <label for="background" class="form-label">Arrière-plan</label>
        <input type="color" class="form-control form-control-color" id="background" name="parametre[background]"
            value="{{ $parametre['background'] ?? '#ffffff' }}">
    </div>
    <div class="mb-3 col-6">
        <label for="color" class="form-label">Couleur des yeux</label>
        <input type="color" class="form-control form-control-color" id="eye-color" name="parametre[eye-color]"
            value="{{ $parametre['eye-color'] ?? '#000000' }}">
    </div>
    <div class="mb-3 col-6">
        <label for="background-eye-color" class="form-label">Contour des yeux</label>
        <input type="color" class="form-control form-control-color" id="background-eye-color"
            name="parametre[background-eye-color]" value="{{ $parametre['background-eye-color'] ?? '#000000' }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="style">Style :</label>
        <select id="style" class="form-control" name="parametre[style]">
            @foreach (['square', 'dot', 'round'] as $style)
                <option value="{{ $style }}" @if ($parametre['style'] == $style) selected @endif>
                    {{ $style }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="eye">forme des yeux :</label>
        <select id="eye" class="form-control" name="parametre[eye]">
            @foreach (['square', 'circle'] as $eye)
                <option value="{{ $eye }}" @if ($parametre['eye'] == $eye) selected @endif>
                    {{ $eye }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label"for="size">Taille :</label>
        <input class="form-control" type="number" id="size" name="parametre[size]" min="100" max="500"
            value="{{ $parametre['size'] ?? 200 }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="margin">Marge :</label>
        <input class="form-control" type="number" id="margin" name="parametre[margin]" min="0" max="10"
            value="{{ $parametre['margin'] ?? 3 }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="error_correction_level">Niveau de correction d'erreur :</label>
        <select id="error_correction_level" class="form-control" name="parametre[error_correction_level]">
            @foreach (['L' => 'Low', 'M' => 'Medium', 'Q' => 'Quartile', 'H' => 'High'] as $index => $ecl)
                <option value="{{ $index }}" @if ($parametre['error_correction_level'] == $index) selected @endif>
                    {{ $ecl }}</option>
            @endforeach
        </select>
    </div>
</div>
