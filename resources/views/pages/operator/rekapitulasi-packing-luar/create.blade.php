@extends('layouts.master')

@section('title', 'Tambah Rekapitulasi Packing Luar')

@section('content')

    <div class="page-section">

        <div class="section-header">
            <h1>Rekapitulasi Packing Luar</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.rekapitulasi-packing-luar.index') }}">
                        Rekapitulasi Packing Luar
                    </a>
                </div>

                <div class="breadcrumb-item active">
                    Tambah
                </div>
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

            <form action="{{ route('operator.rekapitulasi-packing-luar.store') }}" method="POST" id="rekapitulasiForm">

                @csrf

                <div class="card mb-4">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">1</span>
                            Informasi Produksi
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="filter-label">
                                        Tanggal Produksi
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        value="{{ old('tanggal') }}" required>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="filter-label">
                                        Production Batch
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="production_batch_id" id="production_batch_id"
                                        class="form-control select2 @error('production_batch_id') is-invalid @enderror"
                                        required disabled>
                                        <option value="">Pilih tanggal terlebih dahulu</option>
                                    </select>
                                    @error('production_batch_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Product</div>
                                    <div class="info-value" id="batch_product">-</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value" id="batch_code">-</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value" id="batch_shift">-</div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card card-accent mb-4">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">2</span>
                            Rekapitulasi Packing
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_batch">Jumlah Batch</label>
                                <input type="number" step="1" min="0" name="jumlah_batch" id="jumlah_batch"
                                    class="form-control @error('jumlah_batch') is-invalid @enderror"
                                    value="{{ old('jumlah_batch') }}">
                                @error('jumlah_batch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_pack">Jumlah Pack</label>
                                <input type="number" step="0.01" min="0" name="jumlah_pack" id="jumlah_pack"
                                    class="form-control @error('jumlah_pack') is-invalid @enderror"
                                    value="{{ old('jumlah_pack') }}">
                                @error('jumlah_pack')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_boks">Jumlah Boks</label>
                                <input type="number" step="0.01" min="0" name="jumlah_boks" id="jumlah_boks"
                                    class="form-control @error('jumlah_boks') is-invalid @enderror"
                                    value="{{ old('jumlah_boks') }}">
                                @error('jumlah_boks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_kg">Jumlah Kg</label>
                                <input type="number" step="0.01" min="0" name="jumlah_kg" id="jumlah_kg"
                                    class="form-control @error('jumlah_kg') is-invalid @enderror"
                                    value="{{ old('jumlah_kg') }}">
                                @error('jumlah_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="no_bstb">No. BSTB</label>
                                <input type="text" name="no_bstb" id="no_bstb"
                                    class="form-control @error('no_bstb') is-invalid @enderror"
                                    value="{{ old('no_bstb') }}" placeholder="Masukkan nomor BSTB">
                                @error('no_bstb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card mb-4">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">3</span>
                            WIP
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_wip_keluar_bag">Jumlah WIP Keluar (Bag)</label>
                                <input type="number" step="0.01" min="0" name="jumlah_wip_keluar_bag"
                                    id="jumlah_wip_keluar_bag"
                                    class="form-control @error('jumlah_wip_keluar_bag') is-invalid @enderror"
                                    value="{{ old('jumlah_wip_keluar_bag') }}">
                                @error('jumlah_wip_keluar_bag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_wip_keluar_kg">Jumlah WIP Keluar (Kg)</label>
                                <input type="number" step="0.01" min="0" name="jumlah_wip_keluar_kg"
                                    id="jumlah_wip_keluar_kg"
                                    class="form-control @error('jumlah_wip_keluar_kg') is-invalid @enderror"
                                    value="{{ old('jumlah_wip_keluar_kg') }}">
                                @error('jumlah_wip_keluar_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tanggal_transfer">Tanggal Transfer</label>
                                <input type="date" name="tanggal_transfer" id="tanggal_transfer"
                                    class="form-control @error('tanggal_transfer') is-invalid @enderror"
                                    value="{{ old('tanggal_transfer') }}">
                                @error('tanggal_transfer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="wip_masuk">WIP Masuk</label>
                                <input type="text" name="wip_masuk" id="wip_masuk"
                                    class="form-control @error('wip_masuk') is-invalid @enderror"
                                    value="{{ old('wip_masuk') }}" placeholder="Masukkan keterangan WIP masuk">
                                @error('wip_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_wip_masuk">Jumlah WIP Masuk</label>
                                <input type="number" step="0.01" min="0" name="jumlah_wip_masuk"
                                    id="jumlah_wip_masuk"
                                    class="form-control @error('jumlah_wip_masuk') is-invalid @enderror"
                                    value="{{ old('jumlah_wip_masuk') }}">
                                @error('jumlah_wip_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card card-accent mb-4">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">4</span>
                            Personel
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="checker">Checker</label>
                                <input type="text" name="checker" id="checker"
                                    class="form-control @error('checker') is-invalid @enderror"
                                    value="{{ old('checker') }}" placeholder="Masukkan nama checker">
                                @error('checker')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kr">KR</label>
                                <input type="text" name="kr" id="kr"
                                    class="form-control @error('kr') is-invalid @enderror" value="{{ old('kr') }}"
                                    placeholder="Masukkan KR">
                                @error('kr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <div class="card-footer bg-white border-top">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <a href="{{ route('operator.rekapitulasi-packing-luar.index') }}"
                                class="btn btn-ghost mb-2 mb-md-0">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                Simpan Rekapitulasi Packing Luar
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
                width: '100%',
                placeholder: 'Pilih opsi',
                allowClear: true
            });

            function resetBatchInfo() {
                $('#batch_product').text('-');
                $('#batch_code').text('-');
                $('#batch_shift').text('-');
            }

            $('#tanggal').on('change', function() {

                const date = $(this).val();
                const batchSelect = $('#production_batch_id');

                resetBatchInfo();

                if (!date) {
                    batchSelect
                        .empty()
                        .append('<option value="">Pilih tanggal terlebih dahulu</option>')
                        .prop('disabled', true)
                        .trigger('change');

                    return;
                }

                batchSelect
                    .prop('disabled', true)
                    .empty()
                    .append('<option value="">Memuat production batch...</option>')
                    .trigger('change');

                $.ajax({
                    url: `{{ route('operator.production-batch.by-date', ':date') }}`.replace(
                        ':date', date),
                    type: 'GET',

                    success: function(response) {

                        batchSelect
                            .empty()
                            .append('<option value="">Pilih Production Batch</option>');

                        if (response.length === 0) {
                            batchSelect
                                .empty()
                                .append(
                                    '<option value="">Tidak ada production batch pada tanggal ini</option>'
                                )
                                .prop('disabled', true)
                                .trigger('change');

                            return;
                        }

                        response.forEach(function(batch) {
                            const productName = batch.product ? batch.product.name :
                                '-';

                            batchSelect.append(`
                                <option
                                    value="${batch.id}"
                                    data-product="${productName}"
                                    data-kode_batch="${batch.kode_batch ?? '-'}"
                                    data-shift="${batch.shift ?? '-'}"
                                >
                                    ${batch.kode_batch} - ${productName}
                                </option>
                            `);
                        });

                        batchSelect.prop('disabled', false).trigger('change');

                        const oldBatchId = '{{ old('production_batch_id') }}';

                        if (oldBatchId) {
                            batchSelect.val(oldBatchId).trigger('change');
                        }
                    },

                    error: function() {
                        batchSelect
                            .empty()
                            .append('<option value="">Gagal memuat production batch</option>')
                            .prop('disabled', true)
                            .trigger('change');
                    }
                });

            });

            $('#production_batch_id').on('change', function() {

                const selected = $(this).find(':selected');

                if (!$(this).val()) {
                    resetBatchInfo();
                    return;
                }

                $('#batch_product').text(selected.data('product') || '-');
                $('#batch_code').text(selected.data('kode_batch') || '-');
                $('#batch_shift').text(selected.data('shift') ? 'Shift ' + selected.data('shift') : '-');

            });

            @if (old('tanggal'))
                $('#tanggal').trigger('change');
            @endif

        });
    </script>
@endpush
