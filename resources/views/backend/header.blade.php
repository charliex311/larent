<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation">
        <span class="navbar-toggle-icon">
            <span class="toggle-line"></span>
        </span>
    </button>

    <a class="navbar-brand me-1 me-sm-3" href="{{route('dashboard')}}">
        <div class="d-flex align-items-center">
            <img class="me-2" src="{{asset('public/logo.png')}}" alt="" width="150" />
            <span class="font-sans-serif"></span>
        </div>
    </a>

    <ul class="navbar-nav align-items-center d-none d-lg-block">
        @if(role_name(Auth::user()->id) != 'Administrator')
        <li class="nav-item border"> 
            <b class="fs-1 p-3">{{ fullName(Auth::user()->id) . ' ('.role_name(Auth::user()->id).')' }}</b> 
        </li>
        @else
            @livewire('header-search-box')
        @endif
    </ul>

    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
        @if(role_name(Auth::user()->id) == 'Administrator')
        <li class="nav-item border"> 
            <b class="fs-1 p-3">{{ fullName(Auth::user()->id) . ' ('.role_name(Auth::user()->id).')' }}</b> 
        </li>
        @endif


        <li class="nav-item">
            @livewire('header-top')
        </li>
        
        <li class="nav-item mx-2">
            <div class="theme-control-toggle fa-icon-wait">
                <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox"
                    data-theme-control="theme" value="dark" />
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle"
                    data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span
                        class="fas fa-sun fs-0"></span></label>
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle"
                    data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span
                        class="fas fa-moon fs-0"></span></label>
            </div>
        </li>
        
        <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="{{Auth::user()->photo}}" alt="{{Auth::user()->name}}" />
                </div>
            </a>
            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
                aria-labelledby="navbarDropdownUser">
                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                    <a class="dropdown-item fw-bold text-warning text-uppercase border bg-light" href="#!">
                    @if(role_name(Auth::user()->id) == 'Customer')
                        <span>A/C Type : {{ ShowAccountAsCompany(Auth::user()->id) ? ShowAccountAsCompany(Auth::user()->id) : fullName(Auth::user()->id) }}</span>
                    @else 
                        <span>{{ fullName(Auth::user()->id) }}</span>
                    @endif
                    </a>
                    <a class="dropdown-item" href="{{route('settings')}}" wire:navigate>Settings</a>
                    <a class="dropdown-item" href="{{route('admin-logout')}}">Logout</a>
                </div>
            </div>
        </li>

    </ul>
</nav>