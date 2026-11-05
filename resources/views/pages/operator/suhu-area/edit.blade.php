@extends('layouts.master')

@section('title', 'Edit Data Suhu Area')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Data Suhu Area</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.suhu-area.index') }}">Suhu Area</a>
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

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('operator.suhu-area.update', $suhuArea->id) }}" method="POST" id="suhuAreaForm">
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
                                    value="{{ old('tanggal', $suhuArea->productionBatch?->tanggal ? \Carbon\Carbon::parse($suhuArea->productionBatch->tanggal)->format('Y-m-d') : '') }}"
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
                                        {{ $suhuArea->productionBatch?->product?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value" id="batch_code">
                                        {{ $suhuArea->productionBatch?->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value" id="batch_shift">
                                        {{ $suhuArea->productionBatch?->shift ? 'Shift ' . $suhuArea->productionBatch->shift : '-' }}
                                    </div>
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
                                        <th>Area</th>
                                        <th width="200">Standar (°C)</th>
                                        <th width="200">Aktual (°C)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $areas = [
                                            [
                                                'label' => 'Chillroom',
                                                'std' => 'chillroom_std',
                                                'act' => 'chillroom_act',
                                            ],
                                            ['label' => 'Meat Prep', 'std' => 'meatprep_std', 'act' => 'meatprep_act'],
                                            ['label' => 'Cooking', 'std' => 'cooking_std', 'act' => 'cooking_act'],
                                            [
                                                'label' => 'Seasoning',
                                                'std' => 'seasoning_std',
                                                'act' => 'seasoning_act',
                                            ],
                                            [
                                                'label' => 'Cooling Down',
                                                'std' => 'cooling_down_std',
                                                'act' => 'cooling_down_act',
                                            ],
                                            [
                                                'label' => 'Packing Dalam',
                                                'std' => 'packing_dalam_std',
                                                'act' => 'packing_dalam_act',
                                            ],
                                            [
                                                'label' => 'Packing Luar',
                                                'std' => 'packing_luar_std',
                                                'act' => 'packing_luar_act',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($areas as $i => $area)
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td>{{ $area['label'] }}</td>
                                            <td>
                                                <input type="number" name="{{ $area['std'] }}"
                                                    class="form-control @error($area['std']) is-invalid @enderror"
                                                    step="0.01"
                                                    value="{{ old($area['std'], $suhuArea->{$area['std']}) }}">
                                                @error($area['std'])
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="{{ $area['act'] }}"
                                                    class="form-control @error($area['act']) is-invalid @enderror"
                                                    step="0.01"
                                                    value="{{ old($area['act'], $suhuArea->{$area['act']}) }}">
                                                @error($area['act'])
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
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
            const oldBatchId = @json(old('production_batch_id', $suhuArea->production_batch_id));

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
                $('#batch_shift').text(selectedOption.attr('data-shift') ? 'Shift ' + selectedOption.attr(
                    'data-shift') : '-');
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
