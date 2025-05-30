<!DOCTYPE html>
<html lang="fr">

@include('includes.head')

<body>
    <div class="container">
        <div class="content">
            @component('components.alert')
            @endcomponent
            @yield('content')
        </div>
    </div>
    @include('includes.js')

</body>

</html>
