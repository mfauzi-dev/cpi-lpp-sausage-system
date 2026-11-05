@extends('layouts.master')

@section('title', 'Parameter Pemasakan')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Parameter Pemasakan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('operator.parameter-pemasakan.index') }}">Parameter Pemasakan</a>
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

        <div class="mb-4">
            <a href="{{ route('operator.parameter-pemasakan.create') }}" class="btn btn-add">
                <i class="fas fa-plus mr-1"></i>
                Tambah Parameter Pemasakan
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-filter mr-2"></i>Filter Data</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('operator.parameter-pemasakan.index') }}">
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
                                    <option value="1" {{ request('shift') == '1' ? 'selected' : '' }}>Shift 1</option>
                                    <option value="2" {{ request('shift') == '2' ? 'selected' : '' }}>Shift 2</option>
                                    <option value="3" {{ request('shift') == '3' ? 'selected' : '' }}>Shift 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="gap: .5rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>Tampilkan
                        </button>
                        <a href="{{ route('operator.parameter-pemasakan.index') }}" class="btn btn-ghost">
                            <i class="fas fa-sync-alt mr-1"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-accent">
            <div class="card-header">
                <h4><i class="fas fa-fire mr-2"></i>Data Parameter Pemasakan</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-wide">
                        <thead>
                            <tr>
                                <th class="text-center" width="60">No</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Kode Batch</th>
                                <th>Nama Product</th>
                                <th>Penggunaan Mesin</th>
                                <th class="text-center" width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($parameterPemasakans as $index => $parameterPemasakan)
                                <tr>
                                    <td class="text-center">{{ $parameterPemasakans->firstItem() + $index }}</td>
                                    <td>
                                        {{ $parameterPemasakan->productionBatch?->tanggal
                                            ? \Carbon\Carbon::parse($parameterPemasakan->productionBatch->tanggal)->format('d/m/Y')
                                            : '-' }}
                                    </td>
                                    <td>{{ $parameterPemasakan->productionBatch?->shift ? 'Shift ' . $parameterPemasakan->productionBatch->shift : '-' }}
                                    </td>
                                    <td>{{ $parameterPemasakan->productionBatch?->kode_batch ?? '-' }}</td>
                                    <td>{{ $parameterPemasakan->productionBatch->product->name ?? '-' }}</td>
                                    <td>{{ $parameterPemasakan->penggunaan_mesin ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('operator.parameter-pemasakan.detail', $parameterPemasakan->id) }}"
                                                class="btn btn-outline-info" title="Detail">
                                                <i class="fas fa-file-alt"></i> Lihat Detail
                                            </a>
                                            <a href="{{ route('operator.parameter-pemasakan.edit', $parameterPemasakan->id) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form
                                                action="{{ route('operator.parameter-pemasakan.destroy', $parameterPemasakan->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin hapus data parameter pemasakan ini?')">
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
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="fas fa-fire d-block"></i>
                                            <div>Belum ada data parameter pemasakan.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top">
                {{ $parameterPemasakans->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
