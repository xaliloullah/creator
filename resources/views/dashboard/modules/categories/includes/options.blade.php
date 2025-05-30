@foreach ($categories as $categorie)
    <option value="{{ $categorie->id }}" @if (old('categorie_id', $categorie->categorie_id) == $categorie->id) selected @endif>
        {!! str_repeat('--', $depth) !!} {{ $categorie->designation }}
    </option>

    @if ($categorie->Categories ?? [])
        @include('dashboard.modules.categories.includes.options', [
            'categories' => $categorie->Categories,
            'depth' => $depth + 1,
        ])
    @endif
@endforeach
