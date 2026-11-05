@extends('layouts.master')

@section('title', 'Detail Packing Dalam')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Packing Dalam</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('manager.packing-dalam.index') }}">Packing Dalam</a>
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
                                    {{ $packingDalam->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    Produk: {{ $packingDalam->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $packingDalam->productionBatch?->tanggal ? \Carbon\Carbon::parse($packingDalam->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Tanggal Produksi</div>
                                <div class="info-value">
                                    {{ $packingDalam->productionBatch?->tanggal ? \Carbon\Carbon::parse($packingDalam->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $packingDalam->productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">{{ $packingDalam->productionBatch->shift ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $packingDalam->productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Nama Produk</div>
                                <div class="info-value">{{ $packingDalam->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Petugas & Waktu Pengemasan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-user"></i></div>
                                <div>
                                    <div class="stat-label">Petugas Pengemasan</div>
                                    <div class="stat-value">{{ $packingDalam->petugas_pengemasan ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Awal</div>
                                    <div class="stat-value">
                                        {{ $packingDalam->waktu_pengemasan_awal ? \Carbon\Carbon::parse($packingDalam->waktu_pengemasan_awal)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Akhir</div>
                                    <div class="stat-value">
                                        {{ $packingDalam->waktu_pengemasan_akhir ? \Carbon\Carbon::parse($packingDalam->waktu_pengemasan_akhir)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Line Manual</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-hand-paper"></i></div>
                                <div>
                                    <div class="stat-label">Line Manual Single</div>
                                    <div class="stat-value">{{ $packingDalam->line_manual_single ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-hand-paper"></i></div>
                                <div>
                                    <div class="stat-label">Line Manual Dimsum</div>
                                    <div class="stat-value">{{ $packingDalam->line_manual_dimsum ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-hand-paper"></i></div>
                                <div>
                                    <div class="stat-label">Line Manual Baso</div>
                                    <div class="stat-value">{{ $packingDalam->line_manual_baso ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">4</span> Line Thermoforming</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-cogs"></i></div>
                                <div>
                                    <div class="stat-label">Line Thermoforming 1</div>
                                    <div class="stat-value">{{ $packingDalam->line_thermoforming_1 ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-cogs"></i></div>
                                <div>
                                    <div class="stat-label">Line Thermoforming 2</div>
                                    <div class="stat-value">{{ $packingDalam->line_thermoforming_2 ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-cogs"></i></div>
                                <div>
                                    <div class="stat-label">Line Thermoforming 3</div>
                                    <div class="stat-value">{{ $packingDalam->line_thermoforming_3 ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">5</span> Downtime</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kerusakan</div>
                                <div class="info-value">{{ $packingDalam->downtime_kerusakan ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Downtime</div>
                                    <div class="stat-value">
                                        {{ $packingDalam->downtime_waktu !== null ? number_format((float) $packingDalam->downtime_waktu, 2, ',', '.') . ' menit' : '-' }}
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
                            Pastikan data packing dalam sudah sesuai.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('manager.packing-dalam.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
