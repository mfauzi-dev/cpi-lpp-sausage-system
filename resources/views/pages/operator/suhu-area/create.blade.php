@extends('layouts.master')

@section('title', 'Tambah Data Suhu Area')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Tambah Data Suhu Area</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.suhu-area.index') }}">Suhu Area</a>
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

            <form action="{{ route('operator.suhu-area.store') }}" method="POST">
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
                        <h4><span class="step-badge">2</span> Data Suhu Area</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide mb-0">
                                <thead>
                                    <tr class="text-center">
                                        <th width="60">No</th>
                                        <th>Suhu Area</th>
                                        <th width="180">Std (&deg;C)</th>
                                        <th width="180">Act (&deg;C)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Chillroom</td>
                                        <td>
                                            <input type="number" name="chillroom_std" class="form-control" step="0.01"
                                                value="{{ old('chillroom_std') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="chillroom_act" class="form-control" step="0.01"
                                                value="{{ old('chillroom_act') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Meatprep</td>
                                        <td>
                                            <input type="number" name="meatprep_std" class="form-control" step="0.01"
                                                value="{{ old('meatprep_std') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="meatprep_act" class="form-control" step="0.01"
                                                value="{{ old('meatprep_act') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>Cooking</td>
                                        <td>
                                            <input type="number" name="cooking_std" class="form-control" step="0.01"
                                                value="{{ old('cooking_std') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="cooking_act" class="form-control" step="0.01"
                                                value="{{ old('cooking_act') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td>Seasoning</td>
                                        <td>
                                            <input type="number" name="seasoning_std" class="form-control"
                                                step="0.01" value="{{ old('seasoning_std') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="seasoning_act" class="form-control"
                                                step="0.01" value="{{ old('seasoning_act') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">5</td>
                                        <td>Cooling Down</td>
                                        <td>
                                            <input type="number" name="cooling_down_std" class="form-control"
                                                step="0.01" value="{{ old('cooling_down_std') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="cooling_down_act" class="form-control"
                                                step="0.01" value="{{ old('cooling_down_act') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">6</td>
                                        <td>Packing Dalam</td>
                                        <td>
                                            <input type="number" name="packing_dalam_std" class="form-control"
                                                step="0.01" value="{{ old('packing_dalam_std') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="packing_dalam_act" class="form-control"
                                                step="0.01" value="{{ old('packing_dalam_act') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">7</td>
                                        <td>Packing Luar</td>
                                        <td>
                                            <input type="number" name="packing_luar_std" class="form-control"
                                                step="0.01" value="{{ old('packing_luar_std') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="packing_luar_act" class="form-control"
                                                step="0.01" value="{{ old('packing_luar_act') }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.suhu-area.index') }}" class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Data Suhu Area
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
        });
    </script>
@endpush
