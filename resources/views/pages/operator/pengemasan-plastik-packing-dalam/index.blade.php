@extends('layouts.master')

@section('title', 'Pengemasan Plastik Packing Dalam')

@section('content')
    <div class="page-section">

        <div class="section-header">
            <h1>Pengemasan Plastik Packing Dalam</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('operator.pengemasan-plastik-packing-dalam.index') }}">Pengemasan Plastik Packing
                        Dalam</a>
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
            <a href="{{ route('operator.pengemasan-plastik-packing-dalam.create') }}" class="btn btn-add">
                <i class="fas fa-plus mr-1"></i>
                Tambah Pengemasan Plastik Packing Dalam
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
                <form method="GET" action="{{ route('operator.pengemasan-plastik-packing-dalam.index') }}">
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

                        <a href="{{ route('operator.pengemasan-plastik-packing-dalam.index') }}" class="btn btn-ghost">
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
                    Data Pengemasan Plastik Packing Dalam
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
                                <th>Jumlah Jenis Plastik</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($pengemasanPlastikPackingDalams as $index => $row)
                                <tr>
                                    <td class="text-center">
                                        {{ $pengemasanPlastikPackingDalams->firstItem() + $index }}
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
                                                {{ $row->items_count }} Jenis Plastik
                                            </span>
                                        @else
                                            <span class="value-empty">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('operator.pengemasan-plastik-packing-dalam.detail', $row->production_batch_id) }}"
                                                class="btn btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-file-alt"></i> Lihat Detail
                                            </a>

                                            <a href="{{ route('operator.pengemasan-plastik-packing-dalam.edit', $row->production_batch_id) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <form
                                                action="{{ route('operator.pengemasan-plastik-packing-dalam.destroy', $row->production_batch_id) }}"
                                                method="POST" style="display: inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini? Semua baris plastik di dalamnya ikut terhapus.');">
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
                                                Belum ada data Pengemasan Plastik Packing Dalam.
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
                {{ $pengemasanPlastikPackingDalams->withQueryString()->links() }}
            </div>
        </div>

    </div>
@endsection
