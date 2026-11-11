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

            <li class="menu-header">Master Data</li>

            <li class="{{ Request::routeIs('operator.bahan-baku.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.bahan-baku.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Bahan Baku</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.product.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.product.index') }}">
                    <i class="bi bi-boxes"></i>
                    <span>Produk & Formula</span>
                </a>
            </li>


            <li class="{{ Request::routeIs('operator.standar-parameter-produk.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.standar-parameter-produk.index') }}">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Standar Parameter Produk</span>
                </a>
            </li>

            <li class="menu-header">Operational Meat Preparation</li>

            <li class="{{ Request::routeIs('operator.production-batch.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.production-batch.index') }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Production Batch</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.produksi-bahan-baku.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.produksi-bahan-baku.index') }}">
                    <i class="bi bi-basket"></i>
                    <span>Produksi Bahan Baku</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.penggunaan-mesin.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.penggunaan-mesin.index') }}">
                    <i class="bi bi-shield-check"></i>
                    <span>Penggunaan Mesin</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.parameter-produk.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.parameter-produk.index') }}">
                    <i class="bi bi-clipboard2-pulse"></i>
                    <span>Parameter Produk</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.suhu-area.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.suhu-area.index') }}">
                    <i class="bi bi-thermometer-half"></i>
                    <span>Suhu Area</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.parameter-pemasakan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.parameter-pemasakan.index') }}">
                    <i class="bi bi-fire"></i>
                    <span>Parameter Pemasakan</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.monitoring-pemasakan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.monitoring-pemasakan.index') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Monitoring Pemasakan</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.monitoring-line-baso.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.monitoring-line-baso.index') }}">
                    <i class="bi bi-diagram-3"></i>
                    <span>Monitoring Line Baso</span>
                </a>
            </li>

            <li class="menu-header">Operational Reject</li>

            <li class="{{ Request::routeIs('operator.reject.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.reject.index') }}">
                    <i class="bi bi-clipboard2-x"></i>
                    <span>Reject</span>
                </a>
            </li>

            <li class="menu-header">Operational Packing Dalam</li>

            <li class="{{ Request::routeIs('operator.packing-dalam.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.packing-dalam.index') }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Packing Dalam</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.standar-mesin-packing-dalam.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.standar-mesin-packing-dalam.index') }}">
                    <i class="bi bi-gear-wide-connected"></i>
                    <span>Standar Mesin Packing Dalam</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.pengemasan-plastik-packing-dalam.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.pengemasan-plastik-packing-dalam.index') }}">
                    <i class="bi bi-bag-check"></i>
                    <span>Pengemasan Plastik Packing Dalam</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.metal-detector.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.metal-detector.index') }}">
                    <i class="bi bi-shield-check"></i>
                    <span>Metal Detector</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.sampling-packing-dalam.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.sampling-packing-dalam.index') }}">
                    <i class="bi bi-clipboard2-data"></i>
                    <span>Sampling Packing Dalam</span>
                </a>
            </li>

            <li class="menu-header">Operational Packing Dalam</li>

            <li class="{{ Request::routeIs('operator.packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.packing-luar.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Packing Luar</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.pengemasan-packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.pengemasan-packing-luar.index') }}">
                    <i class="bi bi-bag-check-fill"></i>
                    <span>Pengemasan Packing Luar</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.sampling-packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.sampling-packing-luar.index') }}">
                    <i class="bi bi-clipboard2-check"></i>
                    <span>Sampling Packing Luar</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.rekapitulasi-packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.rekapitulasi-packing-luar.index') }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Rekapitulasi Packing Luar</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('operator.karton-box-packing-luar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('operator.karton-box-packing-luar.index') }}">
                    <i class="bi bi-box2"></i>
                    <span>Karton Box Packing Luar</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
