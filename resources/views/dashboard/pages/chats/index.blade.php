<!DOCTYPE html>
<html lang="fr">

@include('includes.head')

<body>
    @include('includes.header')

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.pages.chats.includes.sidebar')
            @component('components.alert')
            @endcomponent
            <main class="main-content">
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
