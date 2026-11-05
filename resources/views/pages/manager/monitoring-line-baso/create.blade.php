@extends('layouts.master')

@section('title', 'Tambah Monitoring Line Baso')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Tambah Monitoring Line Baso</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.monitoring-line-baso.index') }}">Monitoring Line Baso</a>
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

            <form action="{{ route('operator.monitoring-line-baso.store') }}" method="POST">
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
                        <h4><span class="step-badge">2</span> Parameter Pemasakan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="line_baso">Line Baso</label>
                                <select name="line_baso" id="line_baso"
                                    class="form-control @error('line_baso') is-invalid @enderror">
                                    <option value="">-- Pilih Line Baso --</option>
                                    <option value="BOILING TANK 1"
                                        {{ old('line_baso') == 'BOILING TANK 1' ? 'selected' : '' }}>BOILING TANK 1</option>
                                    <option value="BOILING TANK 2"
                                        {{ old('line_baso') == 'BOILING TANK 2' ? 'selected' : '' }}>BOILING TANK 2</option>
                                </select>
                                @error('line_baso')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="parameter_pemasakan_suhu_air">Suhu Air (°C)</label>
                                <input type="number" step="0.01" name="parameter_pemasakan_suhu_air"
                                    id="parameter_pemasakan_suhu_air"
                                    class="form-control @error('parameter_pemasakan_suhu_air') is-invalid @enderror"
                                    value="{{ old('parameter_pemasakan_suhu_air') }}" placeholder="Masukkan suhu air">
                                @error('parameter_pemasakan_suhu_air')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="parameter_pemasakan_suhu_produk">Suhu Produk (°C)</label>
                                <input type="number" step="0.01" name="parameter_pemasakan_suhu_produk"
                                    id="parameter_pemasakan_suhu_produk"
                                    class="form-control @error('parameter_pemasakan_suhu_produk') is-invalid @enderror"
                                    value="{{ old('parameter_pemasakan_suhu_produk') }}"
                                    placeholder="Masukkan suhu produk">
                                @error('parameter_pemasakan_suhu_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label>Bentuk</label>
                                    <select name="parameter_pemasakan_bentuk"
                                        class="form-control @error('parameter_pemasakan_bentuk') is-invalid @enderror">
                                        <option value="">-- Pilih Bentuk --</option>
                                        <option value="OK"
                                            {{ old('parameter_pemasakan_bentuk') == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="Tidak OK"
                                            {{ old('parameter_pemasakan_bentuk') == 'Tidak OK' ? 'selected' : '' }}>Tidak
                                            OK</option>
                                    </select>
                                    @error('parameter_pemasakan_bentuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Waktu Forming</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="waktu_forming_mulai">Waktu Mulai</label>
                                <input type="time" name="waktu_forming_mulai" id="waktu_forming_mulai"
                                    class="form-control @error('waktu_forming_mulai') is-invalid @enderror"
                                    value="{{ old('waktu_forming_mulai') }}">
                                @error('waktu_forming_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="waktu_forming_selesai">Waktu Selesai</label>
                                <input type="time" name="waktu_forming_selesai" id="waktu_forming_selesai"
                                    class="form-control @error('waktu_forming_selesai') is-invalid @enderror"
                                    value="{{ old('waktu_forming_selesai') }}">
                                @error('waktu_forming_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">4</span> Cooling Down</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="cooling_down_mulai">Cooling Down Mulai</label>
                                <input type="time" name="cooling_down_mulai" id="cooling_down_mulai"
                                    class="form-control @error('cooling_down_mulai') is-invalid @enderror"
                                    value="{{ old('cooling_down_mulai') }}">
                                @error('cooling_down_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cooling_down_selesai">Cooling Down Selesai</label>
                                <input type="time" name="cooling_down_selesai" id="cooling_down_selesai"
                                    class="form-control @error('cooling_down_selesai') is-invalid @enderror"
                                    value="{{ old('cooling_down_selesai') }}">
                                @error('cooling_down_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="suhu_produk_matang">Suhu Produk Matang (°C)</label>
                                <input type="number" step="0.01" name="suhu_produk_matang" id="suhu_produk_matang"
                                    class="form-control @error('suhu_produk_matang') is-invalid @enderror"
                                    value="{{ old('suhu_produk_matang') }}" placeholder="Masukkan suhu produk matang">
                                @error('suhu_produk_matang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.monitoring-line-baso.index') }}" class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Monitoring Line Baso
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
