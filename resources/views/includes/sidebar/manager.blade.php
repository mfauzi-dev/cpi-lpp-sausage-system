<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        <!-- BRAND -->
        <div class="sidebar-brand mb-2">
            <a href="#">
                <img src="{{ asset('stisla/dist/assets/img/logo-2.jfif') }}" alt="" width="50px"
                    style="margin-right: 2px;">
                LPP SAUSAGE
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm mb-2">
            <a href="#">LPP</a>
        </div>

        <ul class="sidebar-menu">

            <li class="menu-header">Dashboard</li>

            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">Manajemen User</li>

            <li class="{{ Request::routeIs('manager.user.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.user.index') }}">
                    <i class="bi bi-people"></i>
                    <span>User</span>
                </a>
            </li>

            <li class="menu-header">Operational Meat Preparation</li>

            <li class="{{ Request::routeIs('manager.production-batch.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.production-batch.index') }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Production Batch</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.produksi-bahan-baku.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.produksi-bahan-baku.index') }}">
                    <i class="bi bi-basket"></i>
                    <span>Produksi Bahan Baku</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.penggunaan-mesin.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.penggunaan-mesin.index') }}">
                    <i class="bi bi-shield-check"></i>
                    <span>Penggunaan Mesin</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.parameter-produk.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.parameter-produk.index') }}">
                    <i class="bi bi-clipboard2-pulse"></i>
                    <span>Parameter Produk</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.suhu-area.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.suhu-area.index') }}">
                    <i class="bi bi-thermometer-half"></i>
                    <span>Suhu Area</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.parameter-pemasakan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.parameter-pemasakan.index') }}">
                    <i class="bi bi-fire"></i>
                    <span>Parameter Pemasakan</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.monitoring-pemasakan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.monitoring-pemasakan.index') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Monitoring Pemasakan</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.monitoring-line-baso.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.monitoring-line-baso.index') }}">
                    <i class="bi bi-diagram-3"></i>
                    <span>Monitoring Line Baso</span>
                </a>
            </li>

            <li class="menu-header">Operational Reject</li>

            <li class="{{ Request::routeIs('manager.reject.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.reject.index') }}">
                    <i class="bi bi-clipboard2-x"></i>
                    <span>Reject</span>
                </a>
            </li>

            <li class="menu-header">Operational Packing Dalam</li>

            <li class="{{ Request::routeIs('manager.packing-dalam.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.packing-dalam.index') }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Packing Dalam</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.standar-mesin-packing-dalam.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.standar-mesin-packing-dalam.index') }}">
                    <i class="bi bi-gear-wide-connected"></i>
                    <span>Standar Mesin Packing Dalam</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.pengemasan-plastik-packing-dalam.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.pengemasan-plastik-packing-dalam.index') }}">
                    <i class="bi bi-bag-check"></i>
                    <span>Pengemasan Plastik Packing Dalam</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.metal-detector.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.metal-detector.index') }}">
                    <i class="bi bi-shield-check"></i>
                    <span>Metal Detector</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.sampling-packing-dalam.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.sampling-packing-dalam.index') }}">
                    <i class="bi bi-clipboard2-data"></i>
                    <span>Sampling Packing Dalam</span>
                </a>
            </li>

            <li class="menu-header">Operational Packing Luar</li>

            <li class="{{ Request::routeIs('manager.packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.packing-luar.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Packing Luar</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.pengemasan-packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.pengemasan-packing-luar.index') }}">
                    <i class="bi bi-bag-check-fill"></i>
                    <span>Pengemasan Packing Luar</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.sampling-packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.sampling-packing-luar.index') }}">
                    <i class="bi bi-clipboard2-check"></i>
                    <span>Sampling Packing Luar</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.rekapitulasi-packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.rekapitulasi-packing-luar.index') }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Rekapitulasi Packing Luar</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('manager.karton-box-packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.karton-box-packing-luar.index') }}">
                    <i class="bi bi-box2"></i>
                    <span>Karton Box Packing Luar</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
