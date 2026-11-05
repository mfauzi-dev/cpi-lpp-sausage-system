@extends('layouts.master')

@section('title', 'Edit Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.parameter-produk.index') }}">Parameter Produk</a>
                </div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-lead">
            Perbarui data sampling ke-{{ $parameterProduk->sampling_ke }} untuk production batch terkait.
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

            <form action="{{ route('operator.parameter-produk.update', $parameterProduk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">1</span> Informasi Produksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Production Batch</label>
                                    <select name="production_batch_id" class="form-control select2" required>
                                        <option value="">Pilih Production Batch</option>
                                        @foreach ($productionBatches as $productionBatch)
                                            <option value="{{ $productionBatch->id }}"
                                                {{ old('production_batch_id', $parameterProduk->production_batch_id) == $productionBatch->id ? 'selected' : '' }}>
                                                {{ $productionBatch->kode_batch }} -
                                                {{ $productionBatch->product->name ?? '-' }}
                                                ({{ $productionBatch->tanggal ? \Carbon\Carbon::parse($productionBatch->tanggal)->format('d M Y') : '-' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Sampling Ke</label>
                                    <input type="number" step="1" min="1" name="sampling_ke"
                                        class="form-control"
                                        value="{{ old('sampling_ke', $parameterProduk->sampling_ke) }}" required readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Data Sampling</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="filter-label">Berat / 3 Pcs (gr)</label>
                                    <input type="number" step="0.01" min="0" name="berat_per_3pcs"
                                        class="form-control"
                                        value="{{ old('berat_per_3pcs', $parameterProduk->berat_per_3pcs) }}">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="filter-label">Diameter (mm)</label>
                                    <input type="number" step="0.01" min="0" name="diameter" class="form-control"
                                        value="{{ old('diameter', $parameterProduk->diameter) }}">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="filter-label">Panjang (cm)</label>
                                    <input type="number" step="0.01" min="0" name="panjang" class="form-control"
                                        value="{{ old('panjang', $parameterProduk->panjang) }}">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="filter-label">Berat / Pcs (gr)</label>
                                    <input type="number" step="0.01" min="0" name="berat_per_pcs"
                                        class="form-control"
                                        value="{{ old('berat_per_pcs', $parameterProduk->berat_per_pcs) }}">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="filter-label">Berat Kulit (gr)</label>
                                    <input type="number" step="0.01" min="0" name="berat_kulit"
                                        class="form-control"
                                        value="{{ old('berat_kulit', $parameterProduk->berat_kulit) }}">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="filter-label">Berat Adonan (gr)</label>
                                    <input type="number" step="0.01" min="0" name="berat_adonan"
                                        class="form-control"
                                        value="{{ old('berat_adonan', $parameterProduk->berat_adonan) }}">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="filter-label">Berat / 3 Pcs Akhir (gr)</label>
                                    <input type="number" step="0.01" min="0" name="berat_per_3pcs_akhir"
                                        class="form-control"
                                        value="{{ old('berat_per_3pcs_akhir', $parameterProduk->berat_per_3pcs_akhir) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-end flex-wrap">
                            <a href="{{ route('operator.parameter-produk.detail', $parameterProduk->production_batch_id) }}"
                                class="btn btn-ghost mr-2">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                Simpan Perubahan
                            </button>
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
                width: '100%'
            });
        });
    </script>
@endpush
