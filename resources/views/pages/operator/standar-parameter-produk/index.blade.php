@extends('layouts.master')

@section('title', 'Standar Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Standar Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('operator.standar-parameter-produk.index') }}">Standar Parameter Produk</a>
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
            <a href="{{ route('operator.standar-parameter-produk.create') }}" class="btn btn-add">
                <i class="fas fa-plus mr-1"></i>
                Tambah Standar Parameter Produk
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-filter mr-2"></i>Filter Data</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('operator.standar-parameter-produk.index') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="filter-label">Nama Produk</label>
                                <input type="text" name="name" class="form-control" placeholder="Cari nama produk..."
                                    value="{{ request('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="gap: .5rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>Tampilkan
                        </button>
                        <a href="{{ route('operator.standar-parameter-produk.index') }}" class="btn btn-ghost">
                            <i class="fas fa-sync-alt mr-1"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-accent">
            <div class="card-header">
                <h4><i class="fas fa-clipboard-list mr-2"></i>Data Standar Parameter Produk</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-wide">
                        <thead>
                            <tr>
                                <th class="text-center" width="60">No</th>
                                <th>Nama Produk</th>
                                <th class="text-center">Jumlah Sampling</th>
                                <th class="text-center" width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                    <td class="text-center">{{ $products->firstItem() + $index }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td class="text-center">
                                        {{ $product->standar_parameter_produks_count }} sampling
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('operator.standar-parameter-produk.detail', $product->id) }}"
                                                class="btn btn-outline-info" title="Detail">
                                                <i class="fas fa-file-alt"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-clipboard-list d-block"></i>
                                            <div>Belum ada data standar parameter produk.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
