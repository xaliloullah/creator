<!DOCTYPE html>
<html lang="fr">

@include('dashboard.includes.head')

<body>
    @include('dashboard.includes.header')

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.modules.chats.includes.sidebar')
            @component('components.alert')
            @endcomponent
            <main class="main-content">
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
