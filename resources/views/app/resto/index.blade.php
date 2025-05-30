@php
    use App\Models\Extends\Module;
    Module::initialize();
    $modules = Module::dashboard();
@endphp

<!DOCTYPE html>
<html lang="fr">

@include('dashboard.includes.head')

<body>
    @include('dashboard.includes.header')


    <div class="container-fluid">
        <div class="row">
            @include('dashboard.includes.sidebar')
            @component('components.alert')
            @endcomponent
            <main class="main-content">
                @component('components.breadcrumb')
                @endcomponent
                @yield('content')
            </main>
        </div>
    </div>

    @include('dashboard.includes.js')
</body>

@component('components.modal-logout')
@endcomponent
@component('components.modal-components')
@endcomponent
@component('components.modal-cart')
@endcomponent
@component('components.modal-settings')
@endcomponent

</html>
