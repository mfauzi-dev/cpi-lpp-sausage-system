@extends('layouts.master')

@section('title', 'Edit Standar Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Standar Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.standar-parameter-produk.index') }}">Standar Parameter Produk</a>
                </div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan.</strong>
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

            <form action="{{ route('operator.standar-parameter-produk.update', $standarParameterProduk->id) }}"
                method="POST" id="standarParameterProdukForm">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">1</span> Informasi Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="product_id">Produk <span class="text-danger">*</span></label>
                                <select name="product_id" id="product_id"
                                    class="form-control select2 @error('product_id') is-invalid @enderror" required>
                                    <option value="">Pilih produk</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('product_id', $standarParameterProduk->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Data Standar Parameter Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sampling_ke">Sampling Ke <span class="text-danger">*</span></label>
                                <input type="number" name="sampling_ke" id="sampling_ke" min="1" max="5"
                                    class="form-control @error('sampling_ke') is-invalid @enderror"
                                    value="{{ old('sampling_ke', $standarParameterProduk->sampling_ke) }}" required
                                    readonly>
                                @error('sampling_ke')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="diameter">Diameter (mm)</label>
                                <input type="number" step="0.01" min="0" name="diameter" id="diameter"
                                    class="form-control @error('diameter') is-invalid @enderror"
                                    value="{{ old('diameter', $standarParameterProduk->diameter) }}"
                                    placeholder="Masukkan diameter">
                                @error('diameter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="panjang">Panjang (cm)</label>
                                <input type="number" step="0.01" min="0" name="panjang" id="panjang"
                                    class="form-control @error('panjang') is-invalid @enderror"
                                    value="{{ old('panjang', $standarParameterProduk->panjang) }}"
                                    placeholder="Masukkan panjang">
                                @error('panjang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="berat_per_pcs">Berat per Pcs (gr)</label>
                                <input type="number" step="0.01" min="0" name="berat_per_pcs" id="berat_per_pcs"
                                    class="form-control @error('berat_per_pcs') is-invalid @enderror"
                                    value="{{ old('berat_per_pcs', $standarParameterProduk->berat_per_pcs) }}"
                                    placeholder="Masukkan berat per pcs">
                                @error('berat_per_pcs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="berat_kulit">Berat Kulit (gr)</label>
                                <input type="number" step="0.01" min="0" name="berat_kulit" id="berat_kulit"
                                    class="form-control @error('berat_kulit') is-invalid @enderror"
                                    value="{{ old('berat_kulit', $standarParameterProduk->berat_kulit) }}"
                                    placeholder="Masukkan berat kulit">
                                @error('berat_kulit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="berat_adonan">Berat Adonan (gr)</label>
                                <input type="number" step="0.01" min="0" name="berat_adonan" id="berat_adonan"
                                    class="form-control @error('berat_adonan') is-invalid @enderror"
                                    value="{{ old('berat_adonan', $standarParameterProduk->berat_adonan) }}"
                                    placeholder="Masukkan berat adonan">
                                @error('berat_adonan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.standar-parameter-produk.detail', $standarParameterProduk->product_id) }}"
                        class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: 'Pilih produk',
                allowClear: true
            });
        });
    </script>
@endpush
