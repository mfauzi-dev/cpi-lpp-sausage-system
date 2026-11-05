@extends('layouts.master')

@section('title', 'Detail Data Suhu Area')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Data Suhu Area</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.suhu-area.index') }}">Suhu Area</a>
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
                                    {{ $suhuArea->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    {{ $suhuArea->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ optional($suhuArea->productionBatch)->tanggal ? \Carbon\Carbon::parse($suhuArea->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">
                                    {{ $suhuArea->productionBatch->kode_batch ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">
                                    {{ $suhuArea->productionBatch->shift ? 'Shift ' . $suhuArea->productionBatch->shift : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Product</div>
                                <div class="info-value">
                                    {{ $suhuArea->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Data Suhu Area</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th width="60">No</th>
                                    <th>Suhu Area</th>
                                    <th>Std (&deg;C)</th>
                                    <th>Act (&deg;C)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Chillroom</td>
                                    <td>
                                        {{ $suhuArea->chillroom_std !== null ? number_format($suhuArea->chillroom_std, 2, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        {{ $suhuArea->chillroom_act !== null ? number_format($suhuArea->chillroom_act, 2, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Meatprep</td>
                                    <td>
                                        {{ $suhuArea->meatprep_std !== null ? number_format($suhuArea->meatprep_std, 2, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        {{ $suhuArea->meatprep_act !== null ? number_format($suhuArea->meatprep_act, 2, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Cooking</td>
                                    <td>
                                        {{ $suhuArea->cooking_std !== null ? number_format($suhuArea->cooking_std, 2, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        {{ $suhuArea->cooking_act !== null ? number_format($suhuArea->cooking_act, 2, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Seasoning</td>
                                    <td>
                                        {{ $suhuArea->seasoning_std !== null ? number_format($suhuArea->seasoning_std, 2, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        {{ $suhuArea->seasoning_act !== null ? number_format($suhuArea->seasoning_act, 2, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Cooling Down</td>
                                    <td>
                                        {{ $suhuArea->cooling_down_std !== null ? number_format($suhuArea->cooling_down_std, 2, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        {{ $suhuArea->cooling_down_act !== null ? number_format($suhuArea->cooling_down_act, 2, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>Packing Dalam</td>
                                    <td>
                                        {{ $suhuArea->packing_dalam_std !== null ? number_format($suhuArea->packing_dalam_std, 2, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        {{ $suhuArea->packing_dalam_act !== null ? number_format($suhuArea->packing_dalam_act, 2, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td>Packing Luar</td>
                                    <td>
                                        {{ $suhuArea->packing_luar_std !== null ? number_format($suhuArea->packing_luar_std, 2, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        {{ $suhuArea->packing_luar_act !== null ? number_format($suhuArea->packing_luar_act, 2, ',', '.') : '-' }}
                                    </td>
                                </tr>
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
                            Pastikan data suhu area sudah sesuai sebelum keluar halaman ini.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('operator.suhu-area.edit', $suhuArea->id) }}"
                                class="btn btn-outline-warning">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="{{ route('operator.suhu-area.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
