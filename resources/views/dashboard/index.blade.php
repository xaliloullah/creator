@php
    $modules = App\Models\Bases\Module::all();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
@component('components.modals.logout')
@endcomponent
@component('components.modals.settings')
@endcomponent

</html>
