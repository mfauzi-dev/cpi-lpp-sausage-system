@extends('layouts.master')

@section('title', 'Edit Standar Mesin Packing Dalam')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Standar Mesin Packing Dalam</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.standar-mesin-packing-dalam.index') }}">Standar Mesin Packing Dalam</a>
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

            <form action="{{ route('operator.standar-mesin-packing-dalam.update', $standarMesinPackingDalam->id) }}"
                method="POST" id="standarMesinPackingDalamForm">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">1</span> Informasi Produksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tanggal">Tanggal Produksi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ old('tanggal', $standarMesinPackingDalam->productionBatch?->tanggal ? \Carbon\Carbon::parse($standarMesinPackingDalam->productionBatch->tanggal)->format('Y-m-d') : '') }}"
                                    required>
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
                                    <div class="info-value" id="batch_product">
                                        {{ $standarMesinPackingDalam->productionBatch?->product?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value" id="batch_code">
                                        {{ $standarMesinPackingDalam->productionBatch?->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value" id="batch_shift">
                                        {{ $standarMesinPackingDalam->productionBatch?->shift ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Informasi Mesin</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="parameter_mesin">Parameter Mesin <span class="text-danger">*</span></label>
                                <select name="parameter_mesin" id="parameter_mesin"
                                    class="form-control select2 @error('parameter_mesin') is-invalid @enderror" required>
                                    <option value="">-- Pilih Parameter Mesin --</option>
                                    <option value="Speed"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Speed' ? 'selected' : '' }}>
                                        Speed</option>
                                    <option value="Tekanan"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Tekanan' ? 'selected' : '' }}>
                                        Tekanan</option>
                                    <option value="Seal"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Seal' ? 'selected' : '' }}>
                                        Seal</option>
                                    <option value="Angin"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Angin' ? 'selected' : '' }}>
                                        Angin</option>
                                    <option value="Suhu Forming (°C)"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Suhu Forming (°C)' ? 'selected' : '' }}>
                                        Suhu Forming (°C)</option>
                                    <option value="Vacuum Forming Time (s)"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Vacuum Forming Time (s)' ? 'selected' : '' }}>
                                        Vacuum Forming Time (s)</option>
                                    <option value="Air Forming Time (s)"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Air Forming Time (s)' ? 'selected' : '' }}>
                                        Air Forming Time (s)</option>
                                    <option value="Forming Ventilation Time (s)"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Forming Ventilation Time (s)' ? 'selected' : '' }}>
                                        Forming Ventilation Time (s)</option>
                                    <option value="Suhu Sealing (°C)"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Suhu Sealing (°C)' ? 'selected' : '' }}>
                                        Suhu Sealing (°C)</option>
                                    <option value="Sealing Time (s)"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Sealing Time (s)' ? 'selected' : '' }}>
                                        Sealing Time (s)</option>
                                    <option value="Vacuum Time (mbar)"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Vacuum Time (mbar)' ? 'selected' : '' }}>
                                        Vacuum Time (mbar)</option>
                                    <option value="Penggunaan Filler Plate"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Penggunaan Filler Plate' ? 'selected' : '' }}>
                                        Penggunaan Filler Plate</option>
                                    <option value="Cycle"
                                        {{ old('parameter_mesin', $standarMesinPackingDalam->parameter_mesin) == 'Cycle' ? 'selected' : '' }}>
                                        Cycle</option>
                                </select>
                                @error('parameter_mesin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Penggunaan Mesin</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="penggunaan_mesin_sausage_cutter">Sausage Cutter</label>
                                <input type="text" name="penggunaan_mesin_sausage_cutter"
                                    id="penggunaan_mesin_sausage_cutter"
                                    class="form-control @error('penggunaan_mesin_sausage_cutter') is-invalid @enderror"
                                    value="{{ old('penggunaan_mesin_sausage_cutter', $standarMesinPackingDalam->penggunaan_mesin_sausage_cutter) }}"
                                    placeholder="Masukkan keterangan">
                                @error('penggunaan_mesin_sausage_cutter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="penggunaan_mesin_vacuum_pack">Vacuum Pack</label>
                                <input type="text" name="penggunaan_mesin_vacuum_pack" id="penggunaan_mesin_vacuum_pack"
                                    class="form-control @error('penggunaan_mesin_vacuum_pack') is-invalid @enderror"
                                    value="{{ old('penggunaan_mesin_vacuum_pack', $standarMesinPackingDalam->penggunaan_mesin_vacuum_pack) }}"
                                    placeholder="Masukkan keterangan">
                                @error('penggunaan_mesin_vacuum_pack')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="penggunaan_mesin_thermoforming">Thermoforming</label>
                                <input type="text" name="penggunaan_mesin_thermoforming"
                                    id="penggunaan_mesin_thermoforming"
                                    class="form-control @error('penggunaan_mesin_thermoforming') is-invalid @enderror"
                                    value="{{ old('penggunaan_mesin_thermoforming', $standarMesinPackingDalam->penggunaan_mesin_thermoforming) }}"
                                    placeholder="Masukkan keterangan">
                                @error('penggunaan_mesin_thermoforming')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.standar-mesin-packing-dalam.index') }}" class="btn btn-ghost mb-2">
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
                placeholder: 'Pilih opsi',
                allowClear: true
            });

            const tanggalInput = $('#tanggal');
            const batchSelect = $('#production_batch_id');
            const oldTanggal = @json(old('tanggal'));
            const oldBatchId = @json(old('production_batch_id', $standarMesinPackingDalam->production_batch_id));

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
                            const option = new Option(kodeBatch + ' - ' + productName, batch
                                .id);

                            $(option).attr('data-product', productName);
                            $(option).attr('data-kode-batch', kodeBatch);
                            $(option).attr('data-shift', shift);
                            batchSelect.append(option);
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
                $('#batch_shift').text(selectedOption.attr('data-shift') || '-');
            });

            tanggalInput.on('change', function() {
                loadProductionBatches($(this).val());
            });

            const initialDate = oldTanggal || tanggalInput.val();

            if (initialDate) {
                tanggalInput.val(initialDate);
                loadProductionBatches(initialDate, oldBatchId);
            }
        });
    </script>
@endpush
