@extends('layouts.master')

@section('title', 'Detail Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('manager.parameter-produk.index') }}">Parameter Produk</a>
                </div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <div class="section-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">1</span> Informasi Produksi</h4>
                </div>
                <div class="card-body">
                    <div class="batch-highlight">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="batch-label">Production Batch</div>
                                <div class="batch-number">
                                    {{ $productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    {{ $productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $productionBatch->tanggal ? \Carbon\Carbon::parse($productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">
                                    {{ $productionBatch->kode_batch ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">
                                    {{ $productionBatch->shift ? 'Shift ' . $productionBatch->shift : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Product</div>
                                <div class="info-value">
                                    {{ $productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-vials"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Jumlah Sampling</div>
                                    <div class="stat-value">
                                        {{ $parameterProduks->count() }} sampling
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Data Sampling</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide mb-0">
                            <thead>
                                <tr>
                                    <th width="60" class="text-center">Sampling Ke</th>
                                    <th>Berat / 3 Pcs (gr)</th>
                                    <th>Diameter (mm)</th>
                                    <th>Panjang (cm)</th>
                                    <th>Berat per Pcs (gr)</th>
                                    <th>Berat Kulit (gr)</th>
                                    <th>Berat Adonan (gr)</th>
                                    <th>Berat per 3 Pcs Akhir (gr)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($parameterProduks as $parameterProduk)
                                    <tr>
                                        <td class="text-center font-weight-bold">
                                            {{ $parameterProduk->sampling_ke }}
                                        </td>
                                        <td>
                                            {{ $parameterProduk->berat_per_3pcs !== null
                                                ? number_format($parameterProduk->berat_per_3pcs, 2, ',', '.')
                                                : '-' }}
                                        </td>
                                        <td>
                                            {{ $parameterProduk->diameter !== null ? number_format($parameterProduk->diameter, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $parameterProduk->panjang !== null ? number_format($parameterProduk->panjang, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $parameterProduk->berat_per_pcs !== null ? number_format($parameterProduk->berat_per_pcs, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $parameterProduk->berat_kulit !== null ? number_format($parameterProduk->berat_kulit, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $parameterProduk->berat_adonan !== null ? number_format($parameterProduk->berat_adonan, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $parameterProduk->berat_per_3pcs_akhir !== null
                                                ? number_format($parameterProduk->berat_per_3pcs_akhir, 2, ',', '.')
                                                : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <i class="fas fa-vials d-block"></i>
                                                <div>Belum ada data sampling.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-final">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="section-info mb-2 mb-md-0">
                            <i class="fas fa-info-circle"></i>
                            Pastikan data sampling sudah sesuai sebelum keluar halaman ini.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('manager.parameter-produk.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
