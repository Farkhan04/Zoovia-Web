<style>
    /* Sidebar utama warna ungu */
    #layout-menu {
        background-color: #2B0875 !important;
    }

    /* Header brand/logo */
    #layout-menu .app-brand {
        background-color: #340d85 !important;
    }

    /* Teks nama brand */
    #layout-menu .app-brand-text {
        color: #ffffff !important;
    }

    /* Link menu & teks */
    #layout-menu .menu-link {
        color: #ffffff !important;
    }

    /* Ikon menu */
    #layout-menu .menu-icon {
        color: #ffffff !important;
    }

    /* Judul grup menu */
    #layout-menu .menu-header {
        color: #ffffff !important;
    }

    /* Hover efek */
    #layout-menu .menu-link:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }

    /* Item aktif */
    #layout-menu .menu-item.active>.menu-link {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }
</style>

<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">

            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Zoovia</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 overflow-auto">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon bx bx-home-circle"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <!-- Artikel -->
        <li class="menu-item {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
            <a href="{{ route('admin.artikel.index') }}" class="menu-link">
                <i class="menu-icon bx bx-book"></i>
                <div class="text-truncate">Artikel</div>
            </a>
        </li>

        <!-- Antrian -->
        <li class="menu-item {{ request()->routeIs('admin.antrian.*') ? 'active' : '' }}">
            <a href="{{ route('admin.antrian.index') }}" class="menu-link">
                <i class="menu-icon bx bx-group"></i>
                <div class="text-truncate">Antrian</div>
            </a>
        </li>

        <!-- Rekam Medis -->
        <li class="menu-item {{ request()->routeIs('admin.rekammedis.*') ? 'active' : '' }}">
            <a href="{{ route('admin.rekammedis.index') }}" class="menu-link">
                <i class="menu-icon bx bx-plus-medical"></i>
                <div class="text-truncate">Rekam Medis</div>
            </a>
        </li>

        <!-- Layanan -->
        <li class="menu-item {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
            <a href="{{ route('admin.layanan.index') }}" class="menu-link">
                <i class="menu-icon bx bx-clinic"></i>
                <div class="text-truncate">Layanan</div>
            </a>
        </li>

        <!-- Dokter -->
        <li class="menu-item {{ request()->routeIs('admin.dokter.*') ? 'active' : '' }}">
            <a href="{{ route('admin.dokter.index') }}" class="menu-link">
                <i class="menu-icon bx bx-user-pin"></i>
                <div class="text-truncate">Dokter</div>
            </a>
        </li>

        <!-- Divider -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-tex text-white">Pengaturan</span>
        </li>

        <!-- Pengaturan Profil -->
        <li class="menu-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <a href="{{ route('admin.profile.edit') }}" class="menu-link">
                <i class="menu-icon bx bx-user"></i>
                <div class="text-truncate">Profil</div>
            </a>
        </li>

        <!-- Pengaturan Akun -->
        <li class="menu-item {{ request()->routeIs('admin.gantisandi') ? 'active' : '' }}">
            <a href="{{ route('admin.gantisandi') }}" class="menu-link">
                <i class="menu-icon bx bx-lock"></i>
                <div class="text-truncate">Ganti Kata Sandi</div>
            </a>
        </li>
    </ul>
</aside>

<!-- Overlay menu mobile -->
<div class="bg-overlay" id="layout-menu-overlay" style="display: none;"></div>