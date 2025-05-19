<!-- Navbar -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <!-- Menu toggle button (for mobile) -->
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" id="layout-menu-toggle">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <span class="fw-semibold d-block">Zoovia Klinik Hewan</span>
                </div>
            </div>

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User dropdown -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            @if(Auth::user()->profile && Auth::user()->profile->photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile->photo) }}" alt="profile" class="w-px-40 h-40 rounded-circle object-fit-cover">
                            @else
                                <img src="{{ asset('Admin/assets/img/avatars/1.png') }}" alt="default" class="w-px-40 h-auto rounded-circle">
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            @if(Auth::user()->profile && Auth::user()->profile->photo)
                                                <img src="{{ asset('storage/' . Auth::user()->profile->photo) }}" alt="profile" class="w-px-40 h-auto rounded-circle">
                                            @else
                                                <img src="{{ asset('Admin/assets/img/avatars/1.png') }}" alt="default" class="w-px-40 h-auto rounded-circle">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                        <small class="text-muted">{{ ucfirst(Auth::user()->role ?? 'User') }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider my-1"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.gantisandi') }}">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Ganti Sandi</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider my-1"></div>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">Keluar</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </div>
</nav>
<!-- / Navbar -->