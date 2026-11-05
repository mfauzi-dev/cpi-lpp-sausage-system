@extends('layouts.master')

@section('title', 'Production Batch')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Production Batch</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="#">Production Batch</a>
                </div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>

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
                    <i class="fas fa-filter mr-2"></i>
                    Filter Data
                </h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('manager.production-batch.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filter-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filter-label">Hari</label>
                                <select name="hari" class="form-control">
                                    <option value="">Semua Hari</option>
                                    @foreach (['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'] as $key => $day)
                                        <option value="{{ $day }}" {{ request('hari') == $day ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filter-label">Produk</label>
                                <select name="product_id" class="form-control">
                                    <option value="">Semua Produk</option>
                                    @foreach (\App\Models\Product::orderBy('id')->get() as $product)
                                        <option value="{{ $product->id }}"
                                            {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filter-label">Kode Batch</label>
                                <input type="text" name="kode_batch" class="form-control" placeholder="Cari kode batch"
                                    value="{{ request('kode_batch') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filter-label">Shift</label>
                                <select name="shift" class="form-control">
                                    <option value="">Semua Shift</option>
                                    @foreach ([1, 2, 3] as $shift)
                                        <option value="{{ $shift }}"
                                            {{ request('shift') == $shift ? 'selected' : '' }}>
                                            Shift {{ $shift }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="gap: .5rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>
                            Tampilkan
                        </button>
                        <a href="{{ route('manager.production-batch.index') }}" class="btn btn-ghost">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-accent">
            <div class="card-header">
                <h4>
                    <i class="fas fa-layer-group mr-2"></i>
                    Data Production Batch
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-wide">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Hari</th>
                                <th>Tanggal</th>
                                <th>Kode Batch</th>
                                <th>Produk</th>
                                <th>Yield Meat</th>
                                <th>Total Meat</th>
                                <th>Shift</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productionBatches as $index => $productionBatch)
                                <tr>
                                    <td class="text-center">{{ $productionBatches->firstItem() + $index }}</td>
                                    <td>{{ $productionBatch->hari ?: '-' }}</td>
                                    <td>
                                        @if ($productionBatch->tanggal)
                                            {{ $productionBatch->tanggal->format('d/m/Y') }}
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($productionBatch->kode_batch)
                                            <span class="badge-soft">{{ $productionBatch->kode_batch }}</span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $productionBatch->product->name ?? '-' }}</td>
                                    <td>
                                        {{ $productionBatch->yield_meat !== null ? number_format((float) $productionBatch->yield_meat, 3, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        {{ $productionBatch->total_meat !== null ? number_format((float) $productionBatch->total_meat, 3, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        @if ($productionBatch->shift)
                                            <span class="badge-soft">Shift {{ $productionBatch->shift }}</span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('manager.production-batch.detail', $productionBatch->id) }}"
                                                class="btn btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-file-alt"></i> Lihat Detail
                                            </a>
                                            <a href="{{ route('manager.production-batch.export', $productionBatch->id) }}"
                                                class="btn btn-outline-success" title="Export Excel">
                                                <i class="fas fa-file-excel"></i> Export
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="fas fa-layer-group d-block"></i>
                                            <div>Belum ada data Production Batch.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top">
                {{ $productionBatches->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
