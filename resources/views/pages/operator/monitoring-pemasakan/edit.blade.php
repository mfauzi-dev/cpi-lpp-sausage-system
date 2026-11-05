@extends('layouts.master')

@section('title', 'Edit Monitoring Pemasakan')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Monitoring Pemasakan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.monitoring-pemasakan.index') }}">Monitoring Pemasakan</a>
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

            <form action="{{ route('operator.monitoring-pemasakan.update', $monitoringPemasakan->id) }}" method="POST"
                id="monitoringPemasakanForm">
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
                                    value="{{ old('tanggal', $monitoringPemasakan->productionBatch?->tanggal ? \Carbon\Carbon::parse($monitoringPemasakan->productionBatch->tanggal)->format('Y-m-d') : '') }}"
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
                                        {{ $monitoringPemasakan->productionBatch?->product?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value" id="batch_code">
                                        {{ $monitoringPemasakan->productionBatch?->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value" id="batch_shift">
                                        {{ $monitoringPemasakan->productionBatch?->shift ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Waktu Pemasakan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="waktu_pemasakan_mulai">Waktu Mulai</label>
                                <input type="time" name="waktu_pemasakan_mulai" id="waktu_pemasakan_mulai"
                                    class="form-control @error('waktu_pemasakan_mulai') is-invalid @enderror"
                                    value="{{ old('waktu_pemasakan_mulai', $monitoringPemasakan->waktu_pemasakan_mulai ? \Carbon\Carbon::parse($monitoringPemasakan->waktu_pemasakan_mulai)->format('H:i') : '') }}">
                                @error('waktu_pemasakan_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="waktu_pemasakan_selesai">Waktu Selesai</label>
                                <input type="time" name="waktu_pemasakan_selesai" id="waktu_pemasakan_selesai"
                                    class="form-control @error('waktu_pemasakan_selesai') is-invalid @enderror"
                                    value="{{ old('waktu_pemasakan_selesai', $monitoringPemasakan->waktu_pemasakan_selesai ? \Carbon\Carbon::parse($monitoringPemasakan->waktu_pemasakan_selesai)->format('H:i') : '') }}">
                                @error('waktu_pemasakan_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="jumlah_trolly_pcs">Jumlah Trolly (Pcs)</label>
                                <input type="number" step="0.01" name="jumlah_trolly_pcs" id="jumlah_trolly_pcs"
                                    class="form-control @error('jumlah_trolly_pcs') is-invalid @enderror"
                                    value="{{ old('jumlah_trolly_pcs', $monitoringPemasakan->jumlah_trolly_pcs) }}"
                                    placeholder="Masukkan jumlah trolly">
                                @error('jumlah_trolly_pcs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Cooling Down</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="cooling_down_waktu">Waktu (Menit)</label>
                                <input type="number" step="0.01" name="cooling_down_waktu" id="cooling_down_waktu"
                                    class="form-control @error('cooling_down_waktu') is-invalid @enderror"
                                    value="{{ old('cooling_down_waktu', $monitoringPemasakan->cooling_down_waktu) }}"
                                    placeholder="Masukkan waktu cooling down">
                                @error('cooling_down_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cooling_down_suhu_ruang">Suhu Ruang (°C)</label>
                                <input type="number" step="0.01" name="cooling_down_suhu_ruang"
                                    id="cooling_down_suhu_ruang"
                                    class="form-control @error('cooling_down_suhu_ruang') is-invalid @enderror"
                                    value="{{ old('cooling_down_suhu_ruang', $monitoringPemasakan->cooling_down_suhu_ruang) }}"
                                    placeholder="Masukkan suhu ruang">
                                @error('cooling_down_suhu_ruang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cooling_down_suhu_produk">Suhu Produk (°C)</label>
                                <input type="number" step="0.01" name="cooling_down_suhu_produk"
                                    id="cooling_down_suhu_produk"
                                    class="form-control @error('cooling_down_suhu_produk') is-invalid @enderror"
                                    value="{{ old('cooling_down_suhu_produk', $monitoringPemasakan->cooling_down_suhu_produk) }}"
                                    placeholder="Masukkan suhu produk">
                                @error('cooling_down_suhu_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">4</span> Parameter Proses Lainnya</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pressure_angin">Pressure Angin</label>
                                <input type="number" step="0.01" name="pressure_angin" id="pressure_angin"
                                    class="form-control @error('pressure_angin') is-invalid @enderror"
                                    value="{{ old('pressure_angin', $monitoringPemasakan->pressure_angin) }}"
                                    placeholder="Masukkan pressure angin">
                                @error('pressure_angin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tekanan_steam_header">Tekanan Steam Header</label>
                                <input type="number" step="0.01" name="tekanan_steam_header"
                                    id="tekanan_steam_header"
                                    class="form-control @error('tekanan_steam_header') is-invalid @enderror"
                                    value="{{ old('tekanan_steam_header', $monitoringPemasakan->tekanan_steam_header) }}"
                                    placeholder="Masukkan tekanan steam header">
                                @error('tekanan_steam_header')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="smoke_generator">Smoke Generator</label>
                                <input type="number" step="0.01" name="smoke_generator" id="smoke_generator"
                                    class="form-control @error('smoke_generator') is-invalid @enderror"
                                    value="{{ old('smoke_generator', $monitoringPemasakan->smoke_generator) }}"
                                    placeholder="Masukkan smoke generator">
                                @error('smoke_generator')
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
                                    value="{{ old('downtime_kerusakan', $monitoringPemasakan->downtime_kerusakan) }}"
                                    placeholder="Masukkan jenis kerusakan">
                                @error('downtime_kerusakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="downtime_waktu">Waktu Downtime (Menit)</label>
                                <input type="number" step="0.01" name="downtime_waktu" id="downtime_waktu"
                                    class="form-control @error('downtime_waktu') is-invalid @enderror"
                                    value="{{ old('downtime_waktu', $monitoringPemasakan->downtime_waktu) }}"
                                    placeholder="Masukkan waktu downtime">
                                @error('downtime_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.monitoring-pemasakan.index') }}" class="btn btn-ghost mb-2">
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
            const oldBatchId = @json(old('production_batch_id', $monitoringPemasakan->production_batch_id));

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
