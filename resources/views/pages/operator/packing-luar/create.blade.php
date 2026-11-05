@extends('layouts.master')

@section('title', 'Tambah Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Tambah Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.packing-luar.index') }}">Packing Luar</a>
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

            <form action="{{ route('operator.packing-luar.store') }}" method="POST">
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
                        <h4><span class="step-badge">2</span> Proses Freezing & Parameter</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="proses_freezing">Proses Freezing</label>
                                <select name="proses_freezing" id="proses_freezing"
                                    class="form-control @error('proses_freezing') is-invalid @enderror">
                                    <option value="">Pilih Proses Freezing</option>
                                    <option value="IQF 1" {{ old('proses_freezing') == 'IQF 1' ? 'selected' : '' }}>IQF 1
                                    </option>
                                    <option value="IQF 2" {{ old('proses_freezing') == 'IQF 2' ? 'selected' : '' }}>IQF 2
                                    </option>
                                </select>
                                @error('proses_freezing')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_input">Jumlah Input</label>
                                <input type="number" step="0.01" name="jumlah_input" id="jumlah_input"
                                    class="form-control @error('jumlah_input') is-invalid @enderror"
                                    value="{{ old('jumlah_input') }}" placeholder="Masukkan jumlah input">
                                @error('jumlah_input')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="suhu_iqf">Suhu IQF (°C)</label>
                                <input type="number" step="0.01" name="suhu_iqf" id="suhu_iqf"
                                    class="form-control @error('suhu_iqf') is-invalid @enderror"
                                    value="{{ old('suhu_iqf') }}" placeholder="Masukkan suhu IQF">
                                @error('suhu_iqf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="suhu_produk">Suhu Produk (°C)</label>
                                <input type="number" step="0.01" name="suhu_produk" id="suhu_produk"
                                    class="form-control @error('suhu_produk') is-invalid @enderror"
                                    value="{{ old('suhu_produk') }}" placeholder="Masukkan suhu produk">
                                @error('suhu_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="dweling_time">Dweling Time</label>
                                <input type="text" name="dweling_time" id="dweling_time"
                                    class="form-control @error('dweling_time') is-invalid @enderror"
                                    value="{{ old('dweling_time') }}" placeholder="Masukkan dweling time">
                                @error('dweling_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Waktu Proses</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="waktu_awal">Waktu Awal</label>
                                <input type="time" name="waktu_awal" id="waktu_awal"
                                    class="form-control @error('waktu_awal') is-invalid @enderror"
                                    value="{{ old('waktu_awal') }}">
                                @error('waktu_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="waktu_akhir">Waktu Akhir</label>
                                <input type="time" name="waktu_akhir" id="waktu_akhir"
                                    class="form-control @error('waktu_akhir') is-invalid @enderror"
                                    value="{{ old('waktu_akhir') }}">
                                @error('waktu_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">4</span> Downtime</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="downtime_kerusakan">Kerusakan</label>
                                <input type="text" name="downtime_kerusakan" id="downtime_kerusakan"
                                    class="form-control @error('downtime_kerusakan') is-invalid @enderror"
                                    value="{{ old('downtime_kerusakan') }}" placeholder="Masukkan jenis kerusakan">
                                @error('downtime_kerusakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="downtime_waktu">Waktu Downtime (Menit)</label>
                                <input type="number" step="0.01" name="downtime_waktu" id="downtime_waktu"
                                    class="form-control @error('downtime_waktu') is-invalid @enderror"
                                    value="{{ old('downtime_waktu') }}" placeholder="Masukkan waktu downtime">
                                @error('downtime_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.packing-luar.index') }}" class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Packing Luar
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
                            const hari = batch.kode_batch ?? '-';
                            const shift = batch.shift ?? '-';
                            const kodeBatch = batch.kode_batch ?? batch.id;

                            batchSelect.append(`
                                <option value="${batch.id}"
                                    data-product="${$('<div>').text(productName).html()}"
                                    data-kode_batch="${$('<div>').text(hari).html()}"
                                    data-shift="${$('<div>').text(shift).html()}">
                                    ${$('<div>').text(kodeBatch + ' - ' + productName).html()}
                                </option>
                            `);
                        });

                        batchSelect.prop('disabled', false).trigger('change');

                        if (selectedBatchId) {
                            batchSelect.val(String(selectedBatchId)).trigger('change');
                        }
                    },
                    error: function(xhr) {
                        batchSelect.empty().append(
                            '<option value="">Gagal memuat production batch</option>'
                        );
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
                $('#batch_code').text(selectedOption.attr('data-kode_batch') || '-');
                $('#batch_shift').text(selectedOption.attr('data-shift') || '-');
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
