@extends('layouts.master')

@section('title', 'Detail Sampling Packing Dalam')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Sampling Packing Dalam</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.sampling-packing-dalam.index') }}">Sampling Packing Dalam</a>
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
                                <div class="batch-number">{{ $productionBatch->kode_batch ?? '-' }}</div>
                                <div class="batch-product">{{ $productionBatch->product->name ?? '-' }}</div>
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
                                <div class="info-value">{{ $productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">
                                    {{ $productionBatch->shift ? 'Shift ' . $productionBatch->shift : '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Product</div>
                                <div class="info-value">{{ $productionBatch->product->name ?? '-' }}</div>
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
                                    <div class="stat-value">{{ $samplingPackingDalams->count() }} sampling</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Data Sampling Packing Dalam</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide mb-0">
                            <thead>
                                <tr>
                                    <th width="80" class="text-center">Sampling Ke</th>
                                    <th>Berat Kemasan (gr)</th>
                                    <th>Berat Per Bag (gr)</th>
                                    <th>Range Berat (gr)</th>
                                    <th>Standar Berat (gr)</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($samplingPackingDalams as $samplingPackingDalam)
                                    <tr>
                                        <td class="text-center font-weight-bold">{{ $samplingPackingDalam->sampling_ke }}
                                        </td>
                                        <td>{{ $samplingPackingDalam->berat_kemasan !== null ? $samplingPackingDalam->berat_kemasan : '-' }}
                                        </td>
                                        <td>{{ $samplingPackingDalam->berat_per_bag !== null ? $samplingPackingDalam->berat_per_bag : '-' }}
                                        </td>
                                        <td>{{ $samplingPackingDalam->range_berat !== null ? $samplingPackingDalam->range_berat : '-' }}
                                        </td>
                                        <td>{{ $samplingPackingDalam->standar_berat !== null ? $samplingPackingDalam->standar_berat : '-' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="{{ route('operator.sampling-packing-dalam.edit', $samplingPackingDalam->id) }}"
                                                    class="btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('operator.sampling-packing-dalam.destroy', $samplingPackingDalam->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus sampling ke-{{ $samplingPackingDalam->sampling_ke }} ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
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
                            <a href="{{ route('operator.sampling-packing-dalam.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
