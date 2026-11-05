@extends('layouts.master')

@section('title', 'Detail Karton Box Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Karton Box Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('manager.karton-box-packing-luar.index') }}">Karton Box Packing Luar</a>
                </div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <p class="section-lead">
            Detail pencatatan penggunaan karton box packing luar berdasarkan production batch terkait.
        </p>

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
                    <h4>
                        <span class="step-badge">1</span>
                        Informasi Produksi
                    </h4>
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
                                <div class="batch-number batch-date">
                                    {{ $productionBatch->tanggal ? $productionBatch->tanggal->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $productionBatch->kode_batch ?? '-' }}</div>
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
                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total QTY Box</div>
                                    <div class="stat-value">
                                        {{ number_format($rows->sum('qty_box'), 2, ',', '.') }} Box
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Pemakaian</div>
                                    <div class="stat-value">
                                        {{ number_format($rows->sum('pemakaian'), 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Sisa</div>
                                    <div class="stat-value">
                                        {{ number_format($rows->sum('sisa'), 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Reject</div>
                                    <div class="stat-value">
                                        {{ number_format($rows->sum('reject'), 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4>
                        <span class="step-badge">2</span>
                        Data Karton Box Packing Luar
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide">
                            <thead>
                                <tr>
                                    <th width="60" class="text-center">No</th>
                                    <th>Jenis Karton Box</th>
                                    <th class="text-right">QTY Box</th>
                                    <th class="text-right">Pemakaian</th>
                                    <th class="text-right">Sisa</th>
                                    <th class="text-right">Reject</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rows as $index => $row)
                                    <tr>
                                        <td class="text-center font-weight-bold">
                                            {{ $index + 1 }}
                                        </td>
                                        <td>
                                            {{ $row->jenis_karton_box ?? '-' }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($row->qty_box ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($row->pemakaian ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($row->sisa ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($row->reject ?? 0, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-box-open d-block"></i>
                                                <div>Belum ada data karton box packing luar.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($rows->count() > 0)
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right font-weight-bold">Total</td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($rows->sum('qty_box'), 2, ',', '.') }}
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($rows->sum('pemakaian'), 2, ',', '.') }}
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($rows->sum('sisa'), 2, ',', '.') }}
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($rows->sum('reject'), 2, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-final">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <div class="info-label mb-1">Total QTY Karton Box</div>
                            <div class="stat-value">
                                {{ number_format($rows->sum('qty_box'), 2, ',', '.') }} Box
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <a href="{{ route('manager.karton-box-packing-luar.index') }}" class="btn btn-ghost mr-1">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
