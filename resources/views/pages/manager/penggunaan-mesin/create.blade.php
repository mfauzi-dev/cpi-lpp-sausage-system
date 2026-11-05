@extends('layouts.master')

@section('title', 'Tambah Penggunaan Mesin')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Tambah Penggunaan Mesin</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.penggunaan-mesin.index') }}">Penggunaan Mesin</a>
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

            <form action="{{ route('operator.penggunaan-mesin.store') }}" method="POST">
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
                        <h4><span class="step-badge">2</span> Spesifikasi Mesin</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name">Nama Mesin <span class="text-danger">*</span></label>
                                <select name="name" id="name"
                                    class="form-control select2 @error('name') is-invalid @enderror" required>
                                    <option value="">Pilih nama mesin</option>
                                    @php
                                        $mesinList = [
                                            'MINCER',
                                            'THUMBLER',
                                            'AUTOGRIND',
                                            'MIXER SYDELMAN',
                                            'MIXER CFS',
                                            'EMULSIFIER',
                                            'DICER',
                                            'MIXER SINMAG',
                                            'BOWLCUTTER CATO',
                                            'BOWLCUTTER NOMA',
                                            'STUFFER TOWNSEND',
                                            'STUFFER VEMAG',
                                            'STUFFER HANDTMAN',
                                            'STUFFER FILLING VEMAG',
                                            'ANKO SIOMAY 1',
                                            'ANKO SIOMAY 2',
                                            'TOA GYOZA',
                                            'ANKO MEATBALL',
                                            'TIANFA',
                                        ];
                                    @endphp
                                    @foreach ($mesinList as $mesin)
                                        <option value="{{ $mesin }}" {{ old('name') == $mesin ? 'selected' : '' }}>
                                            {{ $mesin }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="speed_machine">Speed Machine</label>
                                <input type="number" step="0.01" min="0" name="speed_machine" id="speed_machine"
                                    class="form-control @error('speed_machine') is-invalid @enderror"
                                    value="{{ old('speed_machine') }}" placeholder="Masukkan speed machine">
                                @error('speed_machine')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ukuran_holeplate_knife">Ukuran Holeplate / Knife</label>
                                <input type="text" name="ukuran_holeplate_knife" id="ukuran_holeplate_knife"
                                    class="form-control @error('ukuran_holeplate_knife') is-invalid @enderror"
                                    value="{{ old('ukuran_holeplate_knife') }}"
                                    placeholder="Masukkan ukuran holeplate / knife">
                                @error('ukuran_holeplate_knife')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="linker">Linker</label>
                                <input type="text" name="linker" id="linker"
                                    class="form-control @error('linker') is-invalid @enderror" value="{{ old('linker') }}"
                                    placeholder="Masukkan linker">
                                @error('linker')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stuffing_tube">Stuffing Tube</label>
                                <input type="text" name="stuffing_tube" id="stuffing_tube"
                                    class="form-control @error('stuffing_tube') is-invalid @enderror"
                                    value="{{ old('stuffing_tube') }}" placeholder="Masukkan stuffing tube">
                                @error('stuffing_tube')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="twisting">Twisting</label>
                                <input type="text" name="twisting" id="twisting"
                                    class="form-control @error('twisting') is-invalid @enderror"
                                    value="{{ old('twisting') }}" placeholder="Masukkan twisting">
                                @error('twisting')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="chuck">Chuck</label>
                                <input type="text" name="chuck" id="chuck"
                                    class="form-control @error('chuck') is-invalid @enderror" value="{{ old('chuck') }}"
                                    placeholder="Masukkan chuck">
                                @error('chuck')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Waktu Operasional dan Downtime</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" id="waktu_mulai"
                                    class="form-control @error('waktu_mulai') is-invalid @enderror"
                                    value="{{ old('waktu_mulai') }}">
                                @error('waktu_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="waktu_selesai">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" id="waktu_selesai"
                                    class="form-control @error('waktu_selesai') is-invalid @enderror"
                                    value="{{ old('waktu_selesai') }}">
                                @error('waktu_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="downtime_kerusakan">Downtime / Kerusakan</label>
                                <textarea name="downtime_kerusakan" id="downtime_kerusakan" rows="3"
                                    class="form-control @error('downtime_kerusakan') is-invalid @enderror"
                                    placeholder="Masukkan keterangan downtime atau kerusakan">{{ old('downtime_kerusakan') }}</textarea>
                                @error('downtime_kerusakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="downtime_lama_waktu">Downtime Lama Waktu (Menit)</label>
                                <input type="number" step="0.01" min="0" name="downtime_lama_waktu"
                                    id="downtime_lama_waktu"
                                    class="form-control @error('downtime_lama_waktu') is-invalid @enderror"
                                    value="{{ old('downtime_lama_waktu', 0) }}"
                                    placeholder="Masukkan lama downtime dalam menit">
                                @error('downtime_lama_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.penggunaan-mesin.index') }}" class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Penggunaan Mesin
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
