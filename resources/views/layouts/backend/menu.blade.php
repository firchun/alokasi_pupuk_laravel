<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        {{-- logo aplikasi --}}
        <a href="{{ url('/home') }}" class="app-brand-link">
            <span class=" demo menu-text fw-bolder ms-2 " style="font-size: 35px;">SI PUPUK</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ env('APP_NAME') ?? 'Laravel' }}</span>
        </li>
        <li class="menu-item {{ request()->is('home*') ? 'active' : '' }}">
            <a href="{{ url('/home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @if (Auth::user()->role == 'Distributor')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Stok Pupuk</span>
            </li>
            <li class="menu-item {{ request()->is('stok') ? 'active' : '' }}">
                <a href="{{ url('/stok') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-layer"></i>
                    <div data-i18n="Analytics">Pengajuan Stok</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Transaksi</span>
            </li>
            <li class="menu-item {{ request()->is('pengajuan-pupuk') ? 'active' : '' }}">
                <a href="{{ url('/pengajuan-pupuk') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-layer"></i>
                    <div data-i18n="Analytics">Data Pengajuan Petani</div>
                </a>
            </li>
            {{-- <li class="menu-item {{ request()->is('pengambilan') ? 'active' : '' }}">
                <a href="{{ url('/pengambilan') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-layer"></i>
                    <div data-i18n="Analytics">Update Pengambilan</div>
                </a>
            </li> --}}
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Laporan</span>
            </li>
            <li class="menu-item {{ request()->is('laporan/pengajuan') ? 'active' : '' }}">
                <a href="{{ url('/laporan/pengajuan') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-folder"></i>
                    <div data-i18n="Analytics">Laporan Pengajuan</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'PPL')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">MASTER DATA</span>
            </li>
            <li class="menu-item {{ request()->is('jenis-pupuk') ? 'active' : '' }}">
                <a href="{{ url('/jenis-pupuk') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-folder"></i>
                    <div data-i18n="Analytics">Jenis Pupuk</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">GAPOKTAN</span>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ url('/users') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Gapoktan</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">DISTRIBUTOR</span>
            </li>
            <li class="menu-item {{ request()->is('stok') ? 'active' : '' }}">
                <a href="{{ url('/stok') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-layer"></i>
                    <div data-i18n="Analytics">Pengajuan Stok</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('distributor') ? 'active' : '' }}">
                <a href="{{ url('/distributor') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Distributor</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'Gapoktan')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">GAPOKTAN</span>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ url('/users') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">GAPOKTAN</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Kelompok Tani</span>
            </li>
            <li class="menu-item {{ request()->is('pengajuan-pupuk') ? 'active' : '' }}">
                <a href="{{ url('/pengajuan-pupuk') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-layer"></i>
                    <div data-i18n="Analytics">Data Pengajuan</div>
                </a>
            </li>
            <li class="menu-item @if (request()->is('poktan') || request()->is('kelompok-tani*')) active @endif">
                <a href="{{ url('/poktan') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Kelompok Tani</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Laporan</span>
            </li>
            <li class="menu-item {{ request()->is('laporan/pengajuan') ? 'active' : '' }}">
                <a href="{{ url('/laporan/pengajuan') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-folder"></i>
                    <div data-i18n="Analytics">Laporan Pengajuan</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'Poktan')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Kelompok Tani</span>
            </li>
            <li class="menu-item @if (request()->is('kelompok-tani*')) active @endif">
                <a href="{{ url('/kelompok-tani', Auth::id()) }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Anggota Kelompok</div>
                </a>
            </li>
        @endif

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Akun</span>
        </li>
        <li class="menu-item {{ request()->is('profile') ? 'active' : '' }}">
            <a href="{{ url('/profile') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Profile</div>
            </a>
        </li>

    </ul>
</aside>
