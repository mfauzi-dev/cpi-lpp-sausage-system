@extends('layouts.master')

@section('title', 'Detail Data Reject')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Data Reject</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('manager.reject.index') }}">Reject</a>
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
                                    {{ $reject->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    {{ $reject->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ optional($reject->productionBatch)->tanggal ? \Carbon\Carbon::parse($reject->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">
                                    {{ $reject->productionBatch->kode_batch ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">
                                    {{ $reject->productionBatch->shift ? 'Shift ' . $reject->productionBatch->shift : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Product</div>
                                <div class="info-value">
                                    {{ $reject->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Rijek Cooking</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Lepas Twisting</div>
                                <div class="info-value">
                                    {{ number_format((float) ($reject->lepas_twisting_cooking ?? 0), 2, ',', '.') }} Kg
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Jatuh</div>
                                <div class="info-value">
                                    {{ number_format((float) ($reject->jatuh_cooking ?? 0), 2, ',', '.') }} Kg
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Potong</div>
                                <div class="info-value">
                                    {{ number_format((float) ($reject->potong_cooking ?? 0), 2, ',', '.') }} Kg
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Rijek Cooking</div>
                                    <div class="stat-value">
                                        {{ number_format((float) ($reject->total_rijek_cooking_kg ?? 0), 2, ',', '.') }}
                                        Kg
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Rijek Packing</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Lepas Twisting</div>
                                <div class="info-value">
                                    {{ number_format((float) ($reject->lepas_twisting_packing ?? 0), 2, ',', '.') }} Kg
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Jatuh</div>
                                <div class="info-value">
                                    {{ number_format((float) ($reject->jatuh_packing ?? 0), 2, ',', '.') }} Kg
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Potong</div>
                                <div class="info-value">
                                    {{ number_format((float) ($reject->potong_packing ?? 0), 2, ',', '.') }} Kg
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Rijek Packing</div>
                                    <div class="stat-value">
                                        {{ number_format((float) ($reject->total_rijek_packing_kg ?? 0), 2, ',', '.') }}
                                        Kg
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-final">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="section-info mb-2 mb-md-0">
                            <i class="fas fa-info-circle"></i>
                            Pastikan data reject sudah sesuai sebelum keluar halaman ini.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('manager.reject.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
