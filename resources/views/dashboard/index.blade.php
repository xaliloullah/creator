@php
    $modules = App\Models\Module::all()->where('module_id', null);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')

<body>
    @include('includes.header')


    <div class="container-fluid">
        <div class="row">
            @include('includes.sidebar')
            @component('components.alert')
            @endcomponent
            <main class="main-content">
                @component('components.breadcrumb')
                @endcomponent
                @yield('content')
            </main>
        </div>
    </div>

    @include('includes.js')

</body>
@component('components.modals.logout')
@endcomponent
@component('components.modals.settings')
@endcomponent

</html>
