@extends('layouts.master')

@section('title', 'Karton Box Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Karton Box Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('operator.karton-box-packing-luar.index') }}">Karton Box Packing Luar</a>
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

        <div class="mb-4">
            <a href="{{ route('operator.karton-box-packing-luar.create') }}" class="btn btn-add">
                <i class="fas fa-plus mr-1"></i>
                Tambah Karton Box Packing Luar
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>
                    <i class="fas fa-filter mr-2"></i>
                    Filter Data
                </h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('operator.karton-box-packing-luar.index') }}">
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
                        <a href="{{ route('operator.karton-box-packing-luar.index') }}" class="btn btn-ghost">
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
                    Data Karton Box Packing Luar
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
                                <th>Jumlah Jenis Karton Box</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kartonBoxPackingLuars as $index => $row)
                                <tr>
                                    <td class="text-center">
                                        {{ $kartonBoxPackingLuars->firstItem() + $index }}
                                    </td>
                                    <td>
                                        @if ($row->productionBatch?->tanggal)
                                            <span class="badge-soft">
                                                {{ \Carbon\Carbon::parse($row->productionBatch->tanggal)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->productionBatch?->shift)
                                            <span class="badge-soft">
                                                Shift {{ $row->productionBatch->shift }}
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->productionBatch)
                                            <span class="badge-soft">
                                                {{ $row->productionBatch->kode_batch }}
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->productionBatch?->product)
                                            {{ $row->productionBatch->product->name }}
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->items_count > 0)
                                            <span class="badge-value">
                                                {{ $row->items_count }} Jenis Karton Box
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('operator.karton-box-packing-luar.detail', $row->production_batch_id) }}"
                                                class="btn btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-file-alt"></i> Lihat Detail
                                            </a>
                                            <a href="{{ route('operator.karton-box-packing-luar.edit', $row->production_batch_id) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form
                                                action="{{ route('operator.karton-box-packing-luar.destroy', $row->production_batch_id) }}"
                                                method="POST" style="display: inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini? Semua baris karton box di dalamnya ikut terhapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fas fa-boxes d-block"></i>
                                            <div>
                                                Belum ada data Karton Box Packing Luar.
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
                {{ $kartonBoxPackingLuars->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
