@php
    $modules = App\Models\Bases\Module::admin();
@endphp


<!DOCTYPE html>
<html lang="fr">

@include('admin.includes.head')

<body>
    {{-- <div id="translator" style="display: none"></div> --}}
    @include('admin.includes.header')

    <div class="container-fluid">
        <div class="row">
            @include('admin.includes.sidebar')
            @component('components.alert')
            @endcomponent
            <main class="main-content">
                @component('components.breadcrumb')
                @endcomponent
                @yield('content')
            </main>
        </div>
    </div>

    @include('admin.includes.js')
</body>
@component('components.modals.logout')
@endcomponent
@component('components.modals.components')
@endcomponent
@component('components.modals.settings')
@endcomponent

</html>
