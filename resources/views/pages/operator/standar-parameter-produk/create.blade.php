@extends('layouts.master')

@section('title', 'Tambah Standar Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Tambah Standar Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.standar-parameter-produk.index') }}">Standar Parameter Produk</a>
                </div>
                <div class="breadcrumb-item active">Tambah</div>
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

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('operator.standar-parameter-produk.store') }}" method="POST">
                @csrf

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
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide" id="tableSampling">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="60">No</th>
                                        <th>Sampling Ke</th>
                                        <th>Diameter (mm)</th>
                                        <th>Panjang (cm)</th>
                                        <th>Berat per Pcs (gr)</th>
                                        <th>Berat Kulit (gr)</th>
                                        <th>Berat Adonan (gr)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][sampling_ke]"
                                                    class="form-control" value="{{ old("sampling.$i.sampling_ke", $i) }}"
                                                    min="1" max="5" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][diameter]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.diameter") }}">
                                            </td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][panjang]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.panjang") }}">
                                            </td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_per_pcs]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_per_pcs") }}">
                                            </td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_kulit]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_kulit") }}">
                                            </td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_adonan]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_adonan") }}">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.standar-parameter-produk.index') }}" class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Standar Parameter Produk
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
