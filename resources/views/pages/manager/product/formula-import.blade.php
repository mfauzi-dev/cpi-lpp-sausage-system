@extends('layouts.master')

@section('title', 'Import Formula')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.product.index') }}">
                        Produk
                    </a>
                </div>
                <div class="breadcrumb-item active">
                    Import Formula
                </div>
            </div>
        </div>

        <div class="section-body">
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Import Formula gagal.</strong>
                    <div class="mt-2">{{ session('error') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Periksa kembali data yang dipilih.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('operator.product.formula.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>
                            <span class="step-badge">1</span>
                            Pilih Produk
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label class="filter-label">Produk</label>
                            <select name="product_id"
                                class="form-control select2 @error('product_id') is-invalid @enderror">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($products as $p)
                                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>
                            <span class="step-badge">2</span>
                            File Import Formula
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format Excel wajib mengikuti template: kolom pertama berisi kata
                            <code>Formula</code> diikuti nomor formula di kolom-kolom sebelahnya,
                            baris di bawahnya berisi nama bahan baku dan qty, ditutup baris <code>TOTAL</code>.
                            Nama produk <strong>tidak perlu</strong> ditulis di dalam file.
                        </div>

                        <div class="form-group mb-0">
                            <label class="filter-label">File Excel</label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                                accept=".xlsx,.xls" required>

                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="form-text text-muted">
                                Format yang didukung: XLSX, XLS.
                            </small>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="section-info mb-2 mb-md-0">
                                <i class="fas fa-info-circle"></i>
                                Periksa format dan isi file sebelum melakukan import.
                            </div>

                            <div class="action-buttons">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-import mr-1"></i>
                                    Import
                                </button>

                                <a href="{{ route('operator.product.index') }}" class="btn btn-ghost">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Pilih Produk',
                width: '100%'
            });
        });
    </script>
@endpush
