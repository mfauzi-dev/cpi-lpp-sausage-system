@extends('layouts.master')

@section('title', 'Detail Penggunaan Mesin')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Penggunaan Mesin</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.penggunaan-mesin.index') }}">Penggunaan Mesin</a>
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
                                    {{ $penggunaanMesin->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    Produk: {{ $penggunaanMesin->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $penggunaanMesin->productionBatch?->tanggal ? \Carbon\Carbon::parse($penggunaanMesin->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Tanggal Produksi</div>
                                <div class="info-value">
                                    {{ $penggunaanMesin->productionBatch?->tanggal ? \Carbon\Carbon::parse($penggunaanMesin->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $penggunaanMesin->productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">{{ $penggunaanMesin->productionBatch->shift ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $penggunaanMesin->productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Nama Produk</div>
                                <div class="info-value">{{ $penggunaanMesin->productionBatch->product->name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Spesifikasi Mesin</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-cogs"></i></div>
                                <div>
                                    <div class="stat-label">Nama Mesin</div>
                                    <div class="stat-value">{{ $penggunaanMesin->name ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <div>
                                    <div class="stat-label">Speed Machine</div>
                                    <div class="stat-value">
                                        {{ $penggunaanMesin->speed_machine !== null ? number_format((float) $penggunaanMesin->speed_machine, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-circle-notch"></i></div>
                                <div>
                                    <div class="stat-label">Ukuran Holeplate / Knife</div>
                                    <div class="stat-value">{{ $penggunaanMesin->ukuran_holeplate_knife ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-link"></i></div>
                                <div>
                                    <div class="stat-label">Linker</div>
                                    <div class="stat-value">{{ $penggunaanMesin->linker ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-vial"></i></div>
                                <div>
                                    <div class="stat-label">Stuffing Tube</div>
                                    <div class="stat-value">{{ $penggunaanMesin->stuffing_tube ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-sync-alt"></i></div>
                                <div>
                                    <div class="stat-label">Twisting</div>
                                    <div class="stat-value">{{ $penggunaanMesin->twisting ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-circle"></i></div>
                                <div>
                                    <div class="stat-label">Chuck</div>
                                    <div class="stat-value">{{ $penggunaanMesin->chuck ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Waktu Operasional</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Mulai</div>
                                    <div class="stat-value">
                                        {{ $penggunaanMesin->waktu_mulai ? \Carbon\Carbon::parse($penggunaanMesin->waktu_mulai)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                <div>
                                    <div class="stat-label">Waktu Selesai</div>
                                    <div class="stat-value">
                                        {{ $penggunaanMesin->waktu_selesai ? \Carbon\Carbon::parse($penggunaanMesin->waktu_selesai)->format('H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <div>
                                    <div class="stat-label">Speed Machine</div>
                                    <div class="stat-value">
                                        {{ $penggunaanMesin->speed_machine !== null ? number_format((float) $penggunaanMesin->speed_machine, 2, ',', '.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">4</span> Downtime dan Kerusakan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                <div>
                                    <div class="stat-label">Downtime Lama Waktu</div>
                                    <div class="stat-value">
                                        {{ $penggunaanMesin->downtime_lama_waktu !== null ? number_format((float) $penggunaanMesin->downtime_lama_waktu, 2, ',', '.') . ' menit' : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Keterangan Downtime / Kerusakan</div>
                                <div class="info-value" style="white-space: pre-line;">
                                    {{ $penggunaanMesin->downtime_kerusakan ?: '-' }}</div>
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
                            Pastikan data penggunaan mesin sudah sesuai.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('operator.penggunaan-mesin.edit', $penggunaanMesin->id) }}"
                                class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('operator.penggunaan-mesin.destroy', $penggunaanMesin->id) }}"
                                method="POST" style="display: inline;"
                                onsubmit="return confirm('Yakin ingin menghapus data penggunaan mesin ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('operator.penggunaan-mesin.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
