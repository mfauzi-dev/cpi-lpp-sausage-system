@extends('layouts.master')

@section('title', 'Produksi Bahan Baku')

@section('content')
    <div class="page-section">

        <div class="section-header">
            <h1>Produksi Bahan Baku</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('manager.produksi-bahan-baku.index') }}">Produksi Bahan Baku</a>
                </div>

                <div class="breadcrumb-item">
                    Table
                </div>
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
                <form method="GET" action="{{ route('manager.produksi-bahan-baku.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filter-label">Kode Batch</label>
                                <input type="text" name="kode_batch" class="form-control"
                                    placeholder="Cari nomor batch..." value="{{ request('kode_batch') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filter-label">Tanggal Dari</label>
                                <input type="date" name="date_from" class="form-control"
                                    value="{{ request('date_from') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="filter-label">Tanggal Sampai</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
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

                        <a href="{{ route('manager.produksi-bahan-baku.index') }}" class="btn btn-ghost">
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
                    <i class="fas fa-boxes mr-2"></i>
                    Data Produksi Bahan Baku
                </h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-wide">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Kode Batch</th>
                                <th>Product</th>
                                <th>Jumlah Bahan Baku</th>
                                <th>Total (kg)</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($produksiBahanBakus as $index => $produksi)
                                <tr>
                                    <td class="text-center">
                                        {{ $produksiBahanBakus->firstItem() + $index }}
                                    </td>

                                    <td>
                                        @if ($produksi->productionBatch?->tanggal)
                                            <span class="badge-soft">
                                                {{ $produksi->productionBatch->tanggal->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($produksi->productionBatch?->shift)
                                            <span class="badge-soft">
                                                Shift {{ $produksi->productionBatch->shift }}
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($produksi->productionBatch)
                                            <span class="badge-soft">
                                                {{ $produksi->productionBatch->kode_batch }}
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($produksi->productionBatch?->product)
                                            {{ $produksi->productionBatch->product->name }}
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($produksi->items_count > 0)
                                            <span class="badge-value">
                                                {{ $produksi->items_count }} Bahan Baku
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>

                                    <td>{{ number_format($produksi->total, 2, ',', '.') }}</td>

                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('manager.produksi-bahan-baku.detail', $produksi->id) }}"
                                                class="btn btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-file-alt"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="fas fa-boxes d-block"></i>

                                            <div>
                                                Belum ada data Produksi Bahan Baku.
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-top">
                {{ $produksiBahanBakus->withQueryString()->links() }}
            </div>
        </div>

    </div>
@endsection
