<header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
    {{-- <header class="navbar navbar-expand-md navbar-light bg-white shadow-sm" data-bs-theme="dark"> --}}
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white"
        href="{{ route('home') }}">{{ config('app.name', 'ARC Trading') }}</a>

    <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
            <div id="navbarSearch" class="navbar-search w-100 collapse">
                <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search"
                    aria-label="Search">
            </div>
        </li>
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 btn-outline-light" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
        </li>
    </ul>

    <!-- User Dropdown - Now always visible -->
    <div class="nav-item dropdown mr-auto">
        <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
                <a href="" class="dropdown-item">{{ __('Profile') }}</a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </div>

</header>
