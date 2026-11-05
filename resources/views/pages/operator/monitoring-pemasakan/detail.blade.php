@extends('layouts.master')

@section('title', 'Detail Monitoring Pemasakan')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Monitoring Pemasakan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.monitoring-pemasakan.index') }}">Monitoring Pemasakan</a>
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
                                    {{ $monitoringPemasakan->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    Produk: {{ $monitoringPemasakan->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $monitoringPemasakan->productionBatch?->tanggal ? \Carbon\Carbon::parse($monitoringPemasakan->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Tanggal Produksi</div>
                                <div class="info-value">
                                    {{ $monitoringPemasakan->productionBatch?->tanggal ? \Carbon\Carbon::parse($monitoringPemasakan->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $monitoringPemasakan->productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">{{ $monitoringPemasakan->productionBatch->shift ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $monitoringPemasakan->productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Nama Produk</div>
                                <div class="info-value">{{ $monitoringPemasakan->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Waktu Pemasakan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Mulai</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->waktu_pemasakan_mulai ? \Carbon\Carbon::parse($monitoringPemasakan->waktu_pemasakan_mulai)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Selesai</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->waktu_pemasakan_selesai ? \Carbon\Carbon::parse($monitoringPemasakan->waktu_pemasakan_selesai)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-dolly"></i></div>
                                <div>
                                    <div class="stat-label">Jumlah Trolly (Pcs)</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->jumlah_trolly_pcs !== null ? number_format((float) $monitoringPemasakan->jumlah_trolly_pcs, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Cooling Down</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Cooling Down</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->cooling_down_waktu !== null ? number_format((float) $monitoringPemasakan->cooling_down_waktu, 2, ',', '.') . ' menit' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-temperature-low"></i></div>
                                <div>
                                    <div class="stat-label">Suhu Ruang</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->cooling_down_suhu_ruang !== null ? number_format((float) $monitoringPemasakan->cooling_down_suhu_ruang, 2, ',', '.') . ' °C' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-thermometer-half"></i></div>
                                <div>
                                    <div class="stat-label">Suhu Produk</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->cooling_down_suhu_produk !== null ? number_format((float) $monitoringPemasakan->cooling_down_suhu_produk, 2, ',', '.') . ' °C' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">4</span> Parameter Proses Lainnya</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-wind"></i></div>
                                <div>
                                    <div class="stat-label">Pressure Angin</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->pressure_angin !== null ? number_format((float) $monitoringPemasakan->pressure_angin, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <div>
                                    <div class="stat-label">Tekanan Steam Header</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->tekanan_steam_header !== null ? number_format((float) $monitoringPemasakan->tekanan_steam_header, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-smog"></i></div>
                                <div>
                                    <div class="stat-label">Smoke Generator</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->smoke_generator !== null ? number_format((float) $monitoringPemasakan->smoke_generator, 2, ',', '.') : '-' }}
                                    </div>
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
                                <div class="info-value">{{ $monitoringPemasakan->downtime_kerusakan ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Downtime</div>
                                    <div class="stat-value">
                                        {{ $monitoringPemasakan->downtime_waktu !== null ? number_format((float) $monitoringPemasakan->downtime_waktu, 2, ',', '.') . ' menit' : '-' }}
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
                            Pastikan data monitoring pemasakan sudah sesuai.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('operator.monitoring-pemasakan.edit', $monitoringPemasakan->id) }}"
                                class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('operator.monitoring-pemasakan.destroy', $monitoringPemasakan->id) }}"
                                method="POST" style="display: inline;"
                                onsubmit="return confirm('Yakin ingin menghapus data monitoring pemasakan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('operator.monitoring-pemasakan.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
