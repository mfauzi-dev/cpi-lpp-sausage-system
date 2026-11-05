@extends('layouts.master')

@section('title', 'Penggunaan Mesin')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Penggunaan Mesin</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('manager.penggunaan-mesin.index') }}">Penggunaan Mesin</a>
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
                <h4><i class="fas fa-filter mr-2"></i>Filter Data</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('manager.penggunaan-mesin.index') }}">
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
                        <a href="{{ route('manager.penggunaan-mesin.index') }}" class="btn btn-ghost">
                            <i class="fas fa-sync-alt mr-1"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-accent">
            <div class="card-header">
                <h4><i class="fas fa-cogs mr-2"></i>Data Penggunaan Mesin</h4>
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
                                <th>Nama Mesin</th>
                                <th>Speed Machine</th>
                                <th class="text-center" width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penggunaanMesins as $index => $penggunaanMesin)
                                <tr>
                                    <td class="text-center">{{ $penggunaanMesins->firstItem() + $index }}</td>
                                    <td>
                                        {{ $penggunaanMesin->productionBatch?->tanggal
                                            ? \Carbon\Carbon::parse($penggunaanMesin->productionBatch->tanggal)->format('d/m/Y')
                                            : '-' }}
                                    </td>
                                    <td>{{ $penggunaanMesin->productionBatch?->shift ? 'Shift ' . $penggunaanMesin->productionBatch->shift : '-' }}
                                    </td>
                                    <td>{{ $penggunaanMesin->productionBatch?->kode_batch ?? '-' }}</td>
                                    <td>{{ $penggunaanMesin->name ?? '-' }}</td>
                                    <td>{{ $penggunaanMesin->speed_machine ?? 0 }}</td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('manager.penggunaan-mesin.detail', $penggunaanMesin->id) }}"
                                                class="btn btn-outline-info" title="Detail">
                                                <i class="fas fa-file-alt"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fas fa-cogs d-block"></i>
                                            <div>Belum ada data penggunaan mesin.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top">
                {{ $penggunaanMesins->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
