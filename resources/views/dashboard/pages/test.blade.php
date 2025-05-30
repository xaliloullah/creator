<!doctype html>
<html lang="en">

@section('title', 'Test')
@include('dashboard.includes.head')

<body>
    {{-- <a data-copy="test de copy et un autre test" href="#" target="_blank">test</a>
    <button class="btn btn-sm btn-outline-dark ms-3" onclick="copy(this)">
        <i class="bi bi-copy"></i>
    </button>

    <script>
        function copy(button) {
            navigator.clipboard.writeText(button.previousElementSibling.getAttribute('data-copy'))
                .then(() => {
                    button.innerHTML = 'Copié !';
                    setTimeout(() => button.innerHTML = '<i class="bi bi-copy"></i>', 2000);
                });
        }
    </script> --}}

    <main>
        @php
            use App\Models\Bases\Devise;
            $devise = new Devise(100000);
            use App\Models\Bases\Rate;
            // $rates = Rate::all();
            // use App\Models\Bases\Unite;
            // $unite = new Unite(100000, 'm');
        @endphp

        {{-- @foreach ($rates as $rate)
            <p>{{ $rate->getName() }}</p>
            <p>{{ $rate->getSymbol() }}</p>
            <p>{{ $rate->code }}</p>
        @endforeach --}}
        <p>{{ $devise->format() }} {{ $devise->rate }}</p>
        <p>{{ $devise->convert('USD')->format() }} {{ $devise->rate->symbol }}</p>
        <p>{{ $devise->convert('EUR') }} {{ $devise->rate }}</p>
        <p>{{ $devise->convert('JPY') }} {{ $devise->rate }}</p>
        <p>{{ $devise->convert('XOF') }} {{ $devise->rate->name }}</p>
        <p>{{ $devise->convert('EUR') }} {{ $devise->rate->symbol }}</p>
        <p>{{ $devise->base() }} {{ $devise->rate }}</p>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    @include('dashboard.includes.js')
</body>

</html>
