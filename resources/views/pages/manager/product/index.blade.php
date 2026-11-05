@extends('layouts.master')

@section('title', 'Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('operator.product.index') }}">
                        Produk
                    </a>
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

        <div class="mb-4 d-flex align-items-center flex-wrap" style="gap: .5rem;">
            <a href="{{ route('operator.product.create') }}" class="btn btn-add">
                <i class="fas fa-plus mr-1"></i>
                Tambah Produk
            </a>

            <a href="{{ route('operator.product.formula.import') }}" class="btn btn-add">
                <i class="fas fa-file-import mr-1"></i>
                Import Formula
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
                <form method="GET" action="{{ route('operator.product.index') }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="filter-label">
                                Nama Produk
                            </label>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama produk"
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="d-flex align-items-center" style="gap: .5rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>
                            Tampilkan
                        </button>

                        <a href="{{ route('operator.product.index') }}" class="btn btn-ghost">
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
                    <i class="fas fa-drumstick-bite mr-2"></i>
                    Data Produk
                </h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-wide">
                        <thead>
                            <tr>
                                <th width="60">No.</th>
                                <th>Nama Produk</th>
                                <th>Jumlah Formula</th>
                                <th width="180" class="text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                    <td>
                                        {{ $products->firstItem() + $index }}
                                    </td>

                                    <td>
                                        {{ $product->name }}
                                    </td>

                                    <td>
                                        @if ($product->formulas_count > 0)
                                            <span class="badge-soft">
                                                {{ $product->formulas_count }} baris formula
                                            </span>
                                        @else
                                            <span class="value-empty">Belum ada formula</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('operator.product.formula.index', $product->id) }}"
                                                class="btn btn-outline-info" title="Lihat Formula">
                                                <i class="fas fa-flask"></i> Formula
                                            </a>

                                            <a href="{{ route('operator.product.edit', $product->id) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <form action="{{ route('operator.product.destroy', $product->id) }}"
                                                method="POST" style="display: inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus data Produk ini? Formula terkait akan ikut terhapus.');">
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
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-drumstick-bite d-block"></i>
                                            <div>
                                                Belum ada data Produk.
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
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
