<!DOCTYPE html>
<html lang="fr">

@include('dashboard.includes.head')

<body>
    @include('dashboard.modules.chats.includes.header')

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

@component('components.modal-logout')
@endcomponent
@component('components.modal-settings')
@endcomponent

</html>
