@extends('layouts.master')

@section('title', 'Detail Monitoring Line Baso')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Monitoring Line Baso</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.monitoring-line-baso.index') }}">Monitoring Line Baso</a>
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
                                    {{ $monitoringLineBaso->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    Produk: {{ $monitoringLineBaso->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $monitoringLineBaso->productionBatch?->tanggal ? \Carbon\Carbon::parse($monitoringLineBaso->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Tanggal Produksi</div>
                                <div class="info-value">
                                    {{ $monitoringLineBaso->productionBatch?->tanggal ? \Carbon\Carbon::parse($monitoringLineBaso->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $monitoringLineBaso->productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">{{ $monitoringLineBaso->productionBatch->shift ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $monitoringLineBaso->productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Nama Produk</div>
                                <div class="info-value">{{ $monitoringLineBaso->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Parameter Pemasakan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-water"></i></div>
                                <div>
                                    <div class="stat-label">Line Baso</div>
                                    <div class="stat-value">{{ $monitoringLineBaso->line_baso ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-shapes"></i></div>
                                <div>
                                    <div class="stat-label">Bentuk</div>
                                    <div class="stat-value">{{ $monitoringLineBaso->parameter_pemasakan_bentuk ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-tint"></i></div>
                                <div>
                                    <div class="stat-label">Suhu Air</div>
                                    <div class="stat-value">
                                        {{ $monitoringLineBaso->parameter_pemasakan_suhu_air !== null ? number_format((float) $monitoringLineBaso->parameter_pemasakan_suhu_air, 2, ',', '.') . ' °C' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-thermometer-half"></i></div>
                                <div>
                                    <div class="stat-label">Suhu Produk</div>
                                    <div class="stat-value">
                                        {{ $monitoringLineBaso->parameter_pemasakan_suhu_produk !== null ? number_format((float) $monitoringLineBaso->parameter_pemasakan_suhu_produk, 2, ',', '.') . ' °C' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Waktu Forming</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Mulai</div>
                                    <div class="stat-value">
                                        {{ $monitoringLineBaso->waktu_forming_mulai ? \Carbon\Carbon::parse($monitoringLineBaso->waktu_forming_mulai)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Selesai</div>
                                    <div class="stat-value">
                                        {{ $monitoringLineBaso->waktu_forming_selesai ? \Carbon\Carbon::parse($monitoringLineBaso->waktu_forming_selesai)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">4</span> Cooling Down</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                <div>
                                    <div class="stat-label">Cooling Down Mulai</div>
                                    <div class="stat-value">
                                        {{ $monitoringLineBaso->cooling_down_mulai ? \Carbon\Carbon::parse($monitoringLineBaso->cooling_down_mulai)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                <div>
                                    <div class="stat-label">Cooling Down Selesai</div>
                                    <div class="stat-value">
                                        {{ $monitoringLineBaso->cooling_down_selesai ? \Carbon\Carbon::parse($monitoringLineBaso->cooling_down_selesai)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-fire"></i></div>
                                <div>
                                    <div class="stat-label">Suhu Produk Matang</div>
                                    <div class="stat-value">
                                        {{ $monitoringLineBaso->suhu_produk_matang !== null ? number_format((float) $monitoringLineBaso->suhu_produk_matang, 2, ',', '.') . ' °C' : '-' }}
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
                            Pastikan data monitoring line baso sudah sesuai.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('operator.monitoring-line-baso.edit', $monitoringLineBaso->id) }}"
                                class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('operator.monitoring-line-baso.destroy', $monitoringLineBaso->id) }}"
                                method="POST" style="display: inline;"
                                onsubmit="return confirm('Yakin ingin menghapus data monitoring line baso ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('operator.monitoring-line-baso.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
