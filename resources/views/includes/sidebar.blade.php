<!-- Sidebar -->
<div class="sidebar scrollbar collapse d-md-block shadow bg-light bg-gradient" id="sidebar">
    <div class="d-flex flex-column min-vh-100">
        <ul class="nav flex-column mb-sm-auto mb-0 align-items-start w-100" id="menu">
            @foreach ($modules as $module)
                <li class="nav-item w-100">
                    @include('includes.menu', ['module' => $module])
                </li>
            @endforeach
        </ul>
        <div class="card card-ghost shadow-lg mt-auto sticky-bottom mb-3 p-3">
            <a href="#" class="btn btn-outline-dark"></a>
        </div>
    </div>
</div>
