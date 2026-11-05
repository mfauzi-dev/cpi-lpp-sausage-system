@extends('layouts.master')

@section('title', 'Detail Rekapitulasi Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Rekapitulasi Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.rekapitulasi-packing-luar.index') }}">Rekapitulasi Packing Luar</a>
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
                                <div class="batch-number">{{ $rekapitulasiPackingLuar->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">Produk:
                                    {{ $rekapitulasiPackingLuar->productionBatch->product->name ?? '-' }}</div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $rekapitulasiPackingLuar->productionBatch?->tanggal ? \Carbon\Carbon::parse($rekapitulasiPackingLuar->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Tanggal Produksi</div>
                                <div class="info-value">
                                    {{ $rekapitulasiPackingLuar->productionBatch?->tanggal ? \Carbon\Carbon::parse($rekapitulasiPackingLuar->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $rekapitulasiPackingLuar->productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">{{ $rekapitulasiPackingLuar->productionBatch->shift ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $rekapitulasiPackingLuar->productionBatch->kode_batch ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Nama Produk</div>
                                <div class="info-value">
                                    {{ $rekapitulasiPackingLuar->productionBatch->product->name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Jumlah Produk</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                                <div>
                                    <div class="stat-label">Jumlah Batch</div>
                                    <div class="stat-value">
                                        {{ $rekapitulasiPackingLuar->jumlah_batch !== null ? number_format((float) $rekapitulasiPackingLuar->jumlah_batch, 0, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-box"></i></div>
                                <div>
                                    <div class="stat-label">Jumlah Pack</div>
                                    <div class="stat-value">
                                        {{ $rekapitulasiPackingLuar->jumlah_pack !== null ? number_format((float) $rekapitulasiPackingLuar->jumlah_pack, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-boxes"></i></div>
                                <div>
                                    <div class="stat-label">Jumlah Boks</div>
                                    <div class="stat-value">
                                        {{ $rekapitulasiPackingLuar->jumlah_boks !== null ? number_format((float) $rekapitulasiPackingLuar->jumlah_boks, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-weight"></i></div>
                                <div>
                                    <div class="stat-label">Jumlah Kg</div>
                                    <div class="stat-value">
                                        {{ $rekapitulasiPackingLuar->jumlah_kg !== null ? number_format((float) $rekapitulasiPackingLuar->jumlah_kg, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Informasi BSTB dan WIP Keluar</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
                                <div>
                                    <div class="stat-label">Nomor BSTB</div>
                                    <div class="stat-value">{{ $rekapitulasiPackingLuar->no_bstb ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-box"></i></div>
                                <div>
                                    <div class="stat-label">Jumlah WIP Keluar (Bag)</div>
                                    <div class="stat-value">
                                        {{ $rekapitulasiPackingLuar->jumlah_wip_keluar_bag !== null ? number_format((float) $rekapitulasiPackingLuar->jumlah_wip_keluar_bag, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-weight"></i></div>
                                <div>
                                    <div class="stat-label">Jumlah WIP Keluar (Kg)</div>
                                    <div class="stat-value">
                                        {{ $rekapitulasiPackingLuar->jumlah_wip_keluar_kg !== null ? number_format((float) $rekapitulasiPackingLuar->jumlah_wip_keluar_kg, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                                <div>
                                    <div class="stat-label">Tanggal Transfer</div>
                                    <div class="stat-value">
                                        {{ $rekapitulasiPackingLuar->tanggal_transfer ? \Carbon\Carbon::parse($rekapitulasiPackingLuar->tanggal_transfer)->format('d M Y') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">4</span> Informasi WIP Masuk dan Personel</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">WIP Masuk</div>
                                <div class="info-value">{{ $rekapitulasiPackingLuar->wip_masuk ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Jumlah WIP Masuk</div>
                                <div class="info-value">
                                    {{ $rekapitulasiPackingLuar->jumlah_wip_masuk !== null ? number_format((float) $rekapitulasiPackingLuar->jumlah_wip_masuk, 2, ',', '.') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Checker</div>
                                <div class="info-value">{{ $rekapitulasiPackingLuar->checker ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">KR</div>
                                <div class="info-value">{{ $rekapitulasiPackingLuar->kr ?: '-' }}</div>
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
                            Pastikan data rekapitulasi packing luar sudah sesuai.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('operator.rekapitulasi-packing-luar.edit', $rekapitulasiPackingLuar->id) }}"
                                class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form
                                action="{{ route('operator.rekapitulasi-packing-luar.destroy', $rekapitulasiPackingLuar->id) }}"
                                method="POST" style="display: inline;"
                                onsubmit="return confirm('Yakin ingin menghapus data rekapitulasi packing luar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('operator.rekapitulasi-packing-luar.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
