<header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center fw-bold " style="font-size:20px;">
            {{ env('APP_NAME') }}
            {{-- <img src="{{ asset('frontend_theme') }}/assets/img/logo.png" alt="AgriCulture"> --}}
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}"class="{{ Request::is('/') ? 'active fw-bold' : '' }}">Home</a></li>
                <li><a href="{{ url('/pengajuan_pupuk') }}"
                        class="{{ Request::is('pengajuan_pupuk') ? 'active  fw-bold' : '' }}">Pengajuan
                        Pupuk</a></li>
                <li><a href="{{ url('/invoice') }}" class="{{ Request::is('invoice') ? 'active fw-bold' : '' }}">Cek
                        Invoice</a></li>
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                @endguest
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>
