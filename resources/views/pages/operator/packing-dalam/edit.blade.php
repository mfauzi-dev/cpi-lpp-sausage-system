@extends('layouts.master')

@section('title', 'Edit Packing Dalam')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Packing Dalam</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.packing-dalam.index') }}">Packing Dalam</a>
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

            <form action="{{ route('operator.packing-dalam.update', $packingDalam->id) }}" method="POST"
                id="packingDalamForm">
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
                                    value="{{ old('tanggal', $packingDalam->productionBatch?->tanggal ? \Carbon\Carbon::parse($packingDalam->productionBatch->tanggal)->format('Y-m-d') : '') }}"
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
                                        {{ $packingDalam->productionBatch?->product?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value" id="batch_code">
                                        {{ $packingDalam->productionBatch?->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value" id="batch_shift">
                                        {{ $packingDalam->productionBatch?->shift ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Petugas & Waktu Pengemasan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="petugas_pengemasan">Petugas Pengemasan</label>
                                <input type="text" name="petugas_pengemasan" id="petugas_pengemasan"
                                    class="form-control @error('petugas_pengemasan') is-invalid @enderror"
                                    value="{{ old('petugas_pengemasan', $packingDalam->petugas_pengemasan) }}"
                                    placeholder="Masukkan nama petugas">
                                @error('petugas_pengemasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="waktu_pengemasan_awal">Waktu Awal</label>
                                <input type="time" name="waktu_pengemasan_awal" id="waktu_pengemasan_awal"
                                    class="form-control @error('waktu_pengemasan_awal') is-invalid @enderror"
                                    value="{{ old('waktu_pengemasan_awal', $packingDalam->waktu_pengemasan_awal ? \Carbon\Carbon::parse($packingDalam->waktu_pengemasan_awal)->format('H:i') : '') }}">
                                @error('waktu_pengemasan_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="waktu_pengemasan_akhir">Waktu Akhir</label>
                                <input type="time" name="waktu_pengemasan_akhir" id="waktu_pengemasan_akhir"
                                    class="form-control @error('waktu_pengemasan_akhir') is-invalid @enderror"
                                    value="{{ old('waktu_pengemasan_akhir', $packingDalam->waktu_pengemasan_akhir ? \Carbon\Carbon::parse($packingDalam->waktu_pengemasan_akhir)->format('H:i') : '') }}">
                                @error('waktu_pengemasan_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Line Manual</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="line_manual_single">Line Manual Single</label>
                                <input type="text" name="line_manual_single" id="line_manual_single"
                                    class="form-control @error('line_manual_single') is-invalid @enderror"
                                    value="{{ old('line_manual_single', $packingDalam->line_manual_single) }}"
                                    placeholder="Masukkan keterangan">
                                @error('line_manual_single')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="line_manual_dimsum">Line Manual Dimsum</label>
                                <input type="text" name="line_manual_dimsum" id="line_manual_dimsum"
                                    class="form-control @error('line_manual_dimsum') is-invalid @enderror"
                                    value="{{ old('line_manual_dimsum', $packingDalam->line_manual_dimsum) }}"
                                    placeholder="Masukkan keterangan">
                                @error('line_manual_dimsum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="line_manual_baso">Line Manual Baso</label>
                                <input type="text" name="line_manual_baso" id="line_manual_baso"
                                    class="form-control @error('line_manual_baso') is-invalid @enderror"
                                    value="{{ old('line_manual_baso', $packingDalam->line_manual_baso) }}"
                                    placeholder="Masukkan keterangan">
                                @error('line_manual_baso')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">4</span> Line Thermoforming</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="line_thermoforming_1">Line Thermoforming 1</label>
                                <input type="text" name="line_thermoforming_1" id="line_thermoforming_1"
                                    class="form-control @error('line_thermoforming_1') is-invalid @enderror"
                                    value="{{ old('line_thermoforming_1', $packingDalam->line_thermoforming_1) }}"
                                    placeholder="Masukkan keterangan">
                                @error('line_thermoforming_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="line_thermoforming_2">Line Thermoforming 2</label>
                                <input type="text" name="line_thermoforming_2" id="line_thermoforming_2"
                                    class="form-control @error('line_thermoforming_2') is-invalid @enderror"
                                    value="{{ old('line_thermoforming_2', $packingDalam->line_thermoforming_2) }}"
                                    placeholder="Masukkan keterangan">
                                @error('line_thermoforming_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="line_thermoforming_3">Line Thermoforming 3</label>
                                <input type="text" name="line_thermoforming_3" id="line_thermoforming_3"
                                    class="form-control @error('line_thermoforming_3') is-invalid @enderror"
                                    value="{{ old('line_thermoforming_3', $packingDalam->line_thermoforming_3) }}"
                                    placeholder="Masukkan keterangan">
                                @error('line_thermoforming_3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">5</span> Downtime</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="downtime_kerusakan">Kerusakan</label>
                                <input type="text" name="downtime_kerusakan" id="downtime_kerusakan"
                                    class="form-control @error('downtime_kerusakan') is-invalid @enderror"
                                    value="{{ old('downtime_kerusakan', $packingDalam->downtime_kerusakan) }}"
                                    placeholder="Masukkan jenis kerusakan">
                                @error('downtime_kerusakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="downtime_waktu">Waktu Downtime (Menit)</label>
                                <input type="number" step="0.01" name="downtime_waktu" id="downtime_waktu"
                                    class="form-control @error('downtime_waktu') is-invalid @enderror"
                                    value="{{ old('downtime_waktu', $packingDalam->downtime_waktu) }}"
                                    placeholder="Masukkan waktu downtime">
                                @error('downtime_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.packing-dalam.index') }}" class="btn btn-ghost mb-2">
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
            const oldBatchId = @json(old('production_batch_id', $packingDalam->production_batch_id));

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
