@extends('layouts.master')

@section('title', 'Detail Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.packing-luar.index') }}">Packing Luar</a>
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
                                    {{ $packingLuar->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    Produk: {{ $packingLuar->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $packingLuar->productionBatch?->tanggal ? \Carbon\Carbon::parse($packingLuar->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Tanggal Produksi</div>
                                <div class="info-value">
                                    {{ $packingLuar->productionBatch?->tanggal ? \Carbon\Carbon::parse($packingLuar->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $packingLuar->productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">{{ $packingLuar->productionBatch->shift ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $packingLuar->productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Nama Produk</div>
                                <div class="info-value">{{ $packingLuar->productionBatch->product->name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Proses Freezing & Parameter</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-snowflake"></i></div>
                                <div>
                                    <div class="stat-label">Proses Freezing</div>
                                    <div class="stat-value">{{ $packingLuar->proses_freezing ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-weight"></i></div>
                                <div>
                                    <div class="stat-label">Jumlah Input</div>
                                    <div class="stat-value">
                                        {{ $packingLuar->jumlah_input !== null ? number_format((float) $packingLuar->jumlah_input, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-thermometer-half"></i></div>
                                <div>
                                    <div class="stat-label">Suhu IQF</div>
                                    <div class="stat-value">
                                        {{ $packingLuar->suhu_iqf !== null ? number_format((float) $packingLuar->suhu_iqf, 2, ',', '.') . ' °C' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-temperature-low"></i></div>
                                <div>
                                    <div class="stat-label">Suhu Produk</div>
                                    <div class="stat-value">
                                        {{ $packingLuar->suhu_produk !== null ? number_format((float) $packingLuar->suhu_produk, 2, ',', '.') . ' °C' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                                <div>
                                    <div class="stat-label">Dweling Time</div>
                                    <div class="stat-value">{{ $packingLuar->dweling_time ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Waktu Proses</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Awal</div>
                                    <div class="stat-value">
                                        {{ $packingLuar->waktu_awal ? \Carbon\Carbon::parse($packingLuar->waktu_awal)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Akhir</div>
                                    <div class="stat-value">
                                        {{ $packingLuar->waktu_akhir ? \Carbon\Carbon::parse($packingLuar->waktu_akhir)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">4</span> Downtime</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kerusakan</div>
                                <div class="info-value">{{ $packingLuar->downtime_kerusakan ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Downtime</div>
                                    <div class="stat-value">
                                        {{ $packingLuar->downtime_waktu !== null ? number_format((float) $packingLuar->downtime_waktu, 2, ',', '.') . ' menit' : '-' }}
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
                            Pastikan data packing luar sudah sesuai.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('operator.packing-luar.edit', $packingLuar->id) }}"
                                class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('operator.packing-luar.destroy', $packingLuar->id) }}" method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Yakin ingin menghapus data packing luar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('operator.packing-luar.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
