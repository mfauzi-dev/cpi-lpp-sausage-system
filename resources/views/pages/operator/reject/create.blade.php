@extends('layouts.master')

@section('title', 'Tambah Data Reject')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Tambah Data Reject</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.reject.index') }}">Reject</a>
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

            <form action="{{ route('operator.reject.store') }}" method="POST">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">1</span> Informasi Produksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tanggal">Tanggal Produksi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ old('tanggal') }}" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="production_batch_id">Production Batch <span class="text-danger">*</span></label>
                                <select name="production_batch_id" id="production_batch_id"
                                    class="form-control select2 @error('production_batch_id') is-invalid @enderror" required
                                    disabled>
                                    <option value="">Pilih tanggal terlebih dahulu</option>
                                </select>
                                @error('production_batch_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        <h4><span class="step-badge">2</span> Rijek Cooking</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide mb-4">
                                <thead>
                                    <tr class="text-center">
                                        <th width="60">No</th>
                                        <th>Kategori</th>
                                        <th width="220">Berat (Kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Lepas Twisting</td>
                                        <td>
                                            <input type="number" name="lepas_twisting_cooking"
                                                class="form-control rijek-input-cooking" step="0.01" min="0"
                                                value="{{ old('lepas_twisting_cooking') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Jatuh</td>
                                        <td>
                                            <input type="number" name="jatuh_cooking"
                                                class="form-control rijek-input-cooking" step="0.01" min="0"
                                                value="{{ old('jatuh_cooking') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>Potong</td>
                                        <td>
                                            <input type="number" name="potong_cooking"
                                                class="form-control rijek-input-cooking" step="0.01" min="0"
                                                value="{{ old('potong_cooking') }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="info-box">
                                    <div class="info-label">Total Rijek Cooking (Kg)</div>
                                    <input type="number" name="total_rijek_cooking_kg" id="total_rijek_cooking_kg"
                                        class="form-control" step="0.01" value="{{ old('total_rijek_cooking_kg', 0) }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Rijek Packing</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide mb-4">
                                <thead>
                                    <tr class="text-center">
                                        <th width="60">No</th>
                                        <th>Kategori</th>
                                        <th width="220">Berat (Kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Lepas Twisting</td>
                                        <td>
                                            <input type="number" name="lepas_twisting_packing"
                                                class="form-control rijek-input-packing" step="0.01" min="0"
                                                value="{{ old('lepas_twisting_packing') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Jatuh</td>
                                        <td>
                                            <input type="number" name="jatuh_packing"
                                                class="form-control rijek-input-packing" step="0.01" min="0"
                                                value="{{ old('jatuh_packing') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>Potong</td>
                                        <td>
                                            <input type="number" name="potong_packing"
                                                class="form-control rijek-input-packing" step="0.01" min="0"
                                                value="{{ old('potong_packing') }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="info-box">
                                    <div class="info-label">Total Rijek Packing (Kg)</div>
                                    <input type="number" name="total_rijek_packing_kg" id="total_rijek_packing_kg"
                                        class="form-control" step="0.01"
                                        value="{{ old('total_rijek_packing_kg', 0) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.reject.index') }}" class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Data Reject
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
                placeholder: 'Pilih opsi',
                allowClear: true
            });

            const tanggalInput = $('#tanggal');
            const batchSelect = $('#production_batch_id');

            function resetInformasiProduksi() {
                $('#batch_product').text('-');
                $('#batch_code').text('-');
                $('#batch_shift').text('-');
            }

            function loadProductionBatches(date, selectedBatchId = '') {
                batchSelect.empty().append('<option value="">Memuat production batch...</option>');
                batchSelect.prop('disabled', true).trigger('change');
                resetInformasiProduksi();

                if (!date) {
                    batchSelect.empty().append('<option value="">Pilih tanggal terlebih dahulu</option>');
                    batchSelect.prop('disabled', true).trigger('change');
                    return;
                }

                $.ajax({
                    url: `{{ route('operator.production-batch.by-date', ':date') }}`.replace(':date',
                        date),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        batchSelect.empty().append('<option value="">Pilih production batch</option>');

                        if (!Array.isArray(response) || response.length === 0) {
                            batchSelect.empty().append(
                                '<option value="">Tidak ada production batch pada tanggal ini</option>'
                            );
                            batchSelect.prop('disabled', true).trigger('change');
                            return;
                        }

                        response.forEach(function(batch) {
                            const productName = batch.product ? batch.product.name : '-';
                            const kodeBatch = batch.kode_batch ?? '-';
                            const shift = batch.shift ?? '-';

                            batchSelect.append(
                                $('<option>', {
                                    value: batch.id,
                                    text: kodeBatch + ' - ' + productName +
                                        ' - Shift ' + shift
                                }).attr('data-product', productName)
                                .attr('data-kode-batch', kodeBatch)
                                .attr('data-shift', shift)
                            );
                        });

                        batchSelect.prop('disabled', false).trigger('change');

                        if (selectedBatchId) {
                            batchSelect.val(String(selectedBatchId)).trigger('change');
                        }
                    },
                    error: function(xhr) {
                        batchSelect.empty().append(
                            '<option value="">Gagal memuat production batch</option>');
                        batchSelect.prop('disabled', true).trigger('change');
                        resetInformasiProduksi();
                        console.error('Gagal mengambil production batch:', xhr.responseText);
                    }
                });
            }

            batchSelect.on('change', function() {
                const selectedOption = $(this).find('option:selected');

                if (!selectedOption.val()) {
                    resetInformasiProduksi();
                    return;
                }

                $('#batch_product').text(selectedOption.attr('data-product') || '-');
                $('#batch_code').text(selectedOption.attr('data-kode-batch') || '-');
                $('#batch_shift').text(selectedOption.attr('data-shift') ? 'Shift ' + selectedOption.attr(
                    'data-shift') : '-');
            });

            tanggalInput.on('change', function() {
                loadProductionBatches($(this).val());
            });

            const oldTanggal = @json(old('tanggal'));
            const oldBatchId = @json(old('production_batch_id'));

            if (oldTanggal) {
                tanggalInput.val(oldTanggal);
                loadProductionBatches(oldTanggal, oldBatchId);
            }

            function calculateTotal(inputClass, targetId) {
                let total = 0;

                $('.' + inputClass).each(function() {
                    const value = parseFloat($(this).val());

                    if (!isNaN(value)) {
                        total += value;
                    }
                });

                $('#' + targetId).val(total.toFixed(2));
            }

            $(document).on('input', '.rijek-input-cooking', function() {
                calculateTotal('rijek-input-cooking', 'total_rijek_cooking_kg');
            });

            $(document).on('input', '.rijek-input-packing', function() {
                calculateTotal('rijek-input-packing', 'total_rijek_packing_kg');
            });

            calculateTotal('rijek-input-cooking', 'total_rijek_cooking_kg');
            calculateTotal('rijek-input-packing', 'total_rijek_packing_kg');
        });
    </script>
@endpush
