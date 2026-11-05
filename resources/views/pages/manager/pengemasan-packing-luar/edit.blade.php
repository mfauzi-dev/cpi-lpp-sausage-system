@extends('layouts.master')

@section('title', 'Edit Pengemasan Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Pengemasan Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.pengemasan-packing-luar.index') }}">Pengemasan Packing Luar</a>
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

            <form action="{{ route('operator.pengemasan-packing-luar.update', $pengemasanPackingLuar->id) }}" method="POST"
                id="pengemasanPackingLuarForm">
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
                                    value="{{ old('tanggal', $pengemasanPackingLuar->productionBatch?->tanggal ? \Carbon\Carbon::parse($pengemasanPackingLuar->productionBatch->tanggal)->format('Y-m-d') : '') }}"
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
                                        {{ $pengemasanPackingLuar->productionBatch?->product?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value" id="batch_code">
                                        {{ $pengemasanPackingLuar->productionBatch?->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value" id="batch_shift">
                                        {{ $pengemasanPackingLuar->productionBatch?->shift ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Informasi Pengemasan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="parameter_packing_luar">Parameter Packing Luar <span
                                        class="text-danger">*</span></label>
                                <select name="parameter_packing_luar" id="parameter_packing_luar"
                                    class="form-control select2 @error('parameter_packing_luar') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Parameter Packing Luar --</option>
                                    <option value="Pengisian ke dalam boks"
                                        {{ old('parameter_packing_luar', $pengemasanPackingLuar->parameter_packing_luar) == 'Pengisian ke dalam boks' ? 'selected' : '' }}>
                                        Pengisian ke dalam boks</option>
                                    <option value="Sealer boks"
                                        {{ old('parameter_packing_luar', $pengemasanPackingLuar->parameter_packing_luar) == 'Sealer boks' ? 'selected' : '' }}>
                                        Sealer boks</option>
                                    <option value="Check Weigher"
                                        {{ old('parameter_packing_luar', $pengemasanPackingLuar->parameter_packing_luar) == 'Check Weigher' ? 'selected' : '' }}>
                                        Check Weigher</option>
                                </select>
                                @error('parameter_packing_luar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="no_mesin">No. Mesin</label>
                                <input type="text" name="no_mesin" id="no_mesin"
                                    class="form-control @error('no_mesin') is-invalid @enderror"
                                    value="{{ old('no_mesin', $pengemasanPackingLuar->no_mesin) }}"
                                    placeholder="Masukkan nomor mesin">
                                @error('no_mesin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Personel Pengemasan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="petugas">Petugas</label>
                                <input type="text" name="petugas" id="petugas"
                                    class="form-control @error('petugas') is-invalid @enderror"
                                    value="{{ old('petugas', $pengemasanPackingLuar->petugas) }}"
                                    placeholder="Masukkan nama petugas">
                                @error('petugas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="foreman">Foreman</label>
                                <input type="text" name="foreman" id="foreman"
                                    class="form-control @error('foreman') is-invalid @enderror"
                                    value="{{ old('foreman', $pengemasanPackingLuar->foreman) }}"
                                    placeholder="Masukkan nama foreman">
                                @error('foreman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="kr">KR</label>
                                <input type="text" name="kr" id="kr"
                                    class="form-control @error('kr') is-invalid @enderror"
                                    value="{{ old('kr', $pengemasanPackingLuar->kr) }}" placeholder="Masukkan KR">
                                @error('kr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">4</span> Waktu Pengemasan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="waktu_awal">Waktu Awal</label>
                                <input type="time" name="waktu_awal" id="waktu_awal"
                                    class="form-control @error('waktu_awal') is-invalid @enderror"
                                    value="{{ old('waktu_awal', $pengemasanPackingLuar->waktu_awal ? \Carbon\Carbon::parse($pengemasanPackingLuar->waktu_awal)->format('H:i') : '') }}">
                                @error('waktu_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="waktu_akhir">Waktu Akhir</label>
                                <input type="time" name="waktu_akhir" id="waktu_akhir"
                                    class="form-control @error('waktu_akhir') is-invalid @enderror"
                                    value="{{ old('waktu_akhir', $pengemasanPackingLuar->waktu_akhir ? \Carbon\Carbon::parse($pengemasanPackingLuar->waktu_akhir)->format('H:i') : '') }}">
                                @error('waktu_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.pengemasan-packing-luar.index') }}" class="btn btn-ghost mb-2">
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
            const oldBatchId = @json(old('production_batch_id', $pengemasanPackingLuar->production_batch_id));

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
