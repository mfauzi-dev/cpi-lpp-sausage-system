@extends('layouts.master')

@section('title', 'Edit Rekapitulasi Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Rekapitulasi Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.rekapitulasi-packing-luar.index') }}">Rekapitulasi Packing Luar</a>
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
            <form action="{{ route('operator.rekapitulasi-packing-luar.update', $rekapitulasiPackingLuar->id) }}"
                method="POST" id="rekapitulasiPackingLuarForm">
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
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', $rekapitulasiPackingLuar->productionBatch?->tanggal ? \Carbon\Carbon::parse($rekapitulasiPackingLuar->productionBatch->tanggal)->format('Y-m-d') : '') }}"
                                    required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                            <div class="col-md-4 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Product</div>
                                    <div class="info-value" id="batch_product">
                                        {{ $rekapitulasiPackingLuar->productionBatch?->product?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value" id="batch_code">
                                        {{ $rekapitulasiPackingLuar->productionBatch?->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value" id="batch_shift">
                                        {{ $rekapitulasiPackingLuar->productionBatch?->shift ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Jumlah Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_batch">Jumlah Batch</label>
                                <input type="number" step="1" min="0" name="jumlah_batch" id="jumlah_batch"
                                    class="form-control @error('jumlah_batch') is-invalid @enderror"
                                    value="{{ old('jumlah_batch', $rekapitulasiPackingLuar->jumlah_batch) }}"
                                    placeholder="Masukkan jumlah batch">
                                @error('jumlah_batch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_pack">Jumlah Pack</label>
                                <input type="number" step="0.01" min="0" name="jumlah_pack" id="jumlah_pack"
                                    class="form-control @error('jumlah_pack') is-invalid @enderror"
                                    value="{{ old('jumlah_pack', $rekapitulasiPackingLuar->jumlah_pack) }}"
                                    placeholder="Masukkan jumlah pack">
                                @error('jumlah_pack')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_boks">Jumlah Boks</label>
                                <input type="number" step="0.01" min="0" name="jumlah_boks" id="jumlah_boks"
                                    class="form-control @error('jumlah_boks') is-invalid @enderror"
                                    value="{{ old('jumlah_boks', $rekapitulasiPackingLuar->jumlah_boks) }}"
                                    placeholder="Masukkan jumlah boks">
                                @error('jumlah_boks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_kg">Jumlah Kg</label>
                                <input type="number" step="0.01" min="0" name="jumlah_kg" id="jumlah_kg"
                                    class="form-control @error('jumlah_kg') is-invalid @enderror"
                                    value="{{ old('jumlah_kg', $rekapitulasiPackingLuar->jumlah_kg) }}"
                                    placeholder="Masukkan jumlah kg">
                                @error('jumlah_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Informasi BSTB dan WIP Keluar</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_bstb">Nomor BSTB</label>
                                <input type="text" name="no_bstb" id="no_bstb"
                                    class="form-control @error('no_bstb') is-invalid @enderror"
                                    value="{{ old('no_bstb', $rekapitulasiPackingLuar->no_bstb) }}"
                                    placeholder="Masukkan nomor BSTB">
                                @error('no_bstb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_wip_keluar_bag">Jumlah WIP Keluar (Bag)</label>
                                <input type="number" step="0.01" min="0" name="jumlah_wip_keluar_bag"
                                    id="jumlah_wip_keluar_bag"
                                    class="form-control @error('jumlah_wip_keluar_bag') is-invalid @enderror"
                                    value="{{ old('jumlah_wip_keluar_bag', $rekapitulasiPackingLuar->jumlah_wip_keluar_bag) }}"
                                    placeholder="Masukkan jumlah WIP keluar dalam bag">
                                @error('jumlah_wip_keluar_bag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_wip_keluar_kg">Jumlah WIP Keluar (Kg)</label>
                                <input type="number" step="0.01" min="0" name="jumlah_wip_keluar_kg"
                                    id="jumlah_wip_keluar_kg"
                                    class="form-control @error('jumlah_wip_keluar_kg') is-invalid @enderror"
                                    value="{{ old('jumlah_wip_keluar_kg', $rekapitulasiPackingLuar->jumlah_wip_keluar_kg) }}"
                                    placeholder="Masukkan jumlah WIP keluar dalam kg">
                                @error('jumlah_wip_keluar_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_transfer">Tanggal Transfer</label>
                                <input type="date" name="tanggal_transfer" id="tanggal_transfer"
                                    class="form-control @error('tanggal_transfer') is-invalid @enderror"
                                    value="{{ old('tanggal_transfer', $rekapitulasiPackingLuar->tanggal_transfer ? \Carbon\Carbon::parse($rekapitulasiPackingLuar->tanggal_transfer)->format('Y-m-d') : '') }}">
                                @error('tanggal_transfer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">4</span> Informasi WIP Masuk dan Personel</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="wip_masuk">WIP Masuk</label>
                                <input type="text" name="wip_masuk" id="wip_masuk"
                                    class="form-control @error('wip_masuk') is-invalid @enderror"
                                    value="{{ old('wip_masuk', $rekapitulasiPackingLuar->wip_masuk) }}"
                                    placeholder="Masukkan informasi WIP masuk">
                                @error('wip_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_wip_masuk">Jumlah WIP Masuk</label>
                                <input type="number" step="0.01" min="0" name="jumlah_wip_masuk"
                                    id="jumlah_wip_masuk"
                                    class="form-control @error('jumlah_wip_masuk') is-invalid @enderror"
                                    value="{{ old('jumlah_wip_masuk', $rekapitulasiPackingLuar->jumlah_wip_masuk) }}"
                                    placeholder="Masukkan jumlah WIP masuk">
                                @error('jumlah_wip_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="checker">Checker</label>
                                <input type="text" name="checker" id="checker"
                                    class="form-control @error('checker') is-invalid @enderror"
                                    value="{{ old('checker', $rekapitulasiPackingLuar->checker) }}"
                                    placeholder="Masukkan nama checker">
                                @error('checker')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kr">KR</label>
                                <input type="text" name="kr" id="kr"
                                    class="form-control @error('kr') is-invalid @enderror"
                                    value="{{ old('kr', $rekapitulasiPackingLuar->kr) }}" placeholder="Masukkan nama KR">
                                @error('kr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.rekapitulasi-packing-luar.index') }}" class="btn btn-ghost mb-2">
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
            const oldBatchId = @json(old('production_batch_id', $rekapitulasiPackingLuar->production_batch_id));

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
