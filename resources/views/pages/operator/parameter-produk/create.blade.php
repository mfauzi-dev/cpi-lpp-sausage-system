@extends('layouts.master')

@section('title', 'Tambah Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Tambah Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.parameter-produk.index') }}">Parameter Produk</a>
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

            <form action="{{ route('operator.parameter-produk.store') }}" method="POST">
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
                        <h4><span class="step-badge">2</span> Data Parameter Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide" id="tableSampling">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center align-middle" width="60">No</th>
                                        <th rowspan="2" class="align-middle">Sampling Ke</th>
                                        <th rowspan="2" class="align-middle">Berat per 3 Pcs (gr)</th>
                                        <th colspan="2" class="text-center">Diameter (mm)</th>
                                        <th colspan="2" class="text-center">Panjang (cm)</th>
                                        <th colspan="2" class="text-center">Berat per Pcs (gr)</th>
                                        <th colspan="2" class="text-center">Berat Kulit (gr)</th>
                                        <th colspan="2" class="text-center">Berat Adonan (gr)</th>
                                        <th rowspan="2" class="align-middle">Berat per 3 Pcs Akhir (gr)</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][sampling_ke]"
                                                    class="form-control" value="{{ old("sampling.$i.sampling_ke", $i) }}"
                                                    min="1" max="5" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_per_3pcs]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_per_3pcs") }}">
                                            </td>

                                            <td class="text-center text-muted align-middle standar-value"
                                                data-sampling="{{ $i }}" data-field="diameter">-</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][diameter]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.diameter") }}">
                                            </td>

                                            <td class="text-center text-muted align-middle standar-value"
                                                data-sampling="{{ $i }}" data-field="panjang">-</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][panjang]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.panjang") }}">
                                            </td>

                                            <td class="text-center text-muted align-middle standar-value"
                                                data-sampling="{{ $i }}" data-field="berat_per_pcs">-</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_per_pcs]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_per_pcs") }}">
                                            </td>

                                            <td class="text-center text-muted align-middle standar-value"
                                                data-sampling="{{ $i }}" data-field="berat_kulit">-</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_kulit]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_kulit") }}">
                                            </td>

                                            <td class="text-center text-muted align-middle standar-value"
                                                data-sampling="{{ $i }}" data-field="berat_adonan">-</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_adonan]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_adonan") }}">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    name="sampling[{{ $i }}][berat_per_3pcs_akhir]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_per_3pcs_akhir") }}">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.parameter-produk.index') }}" class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Parameter Produk
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
            const standarMap = @json($standarMap);

            function resetInformasiProduksi() {
                $('#batch_product').text('-');
                $('#batch_code').text('-');
                $('#batch_shift').text('-');
            }

            function resetStandar() {
                $('.standar-value').text('-');
            }

            function formatAngka(value) {
                if (value === null || value === undefined || value === '') {
                    return '-';
                }

                return Number(value).toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function tampilkanStandar(productId) {
                resetStandar();

                if (!productId) {
                    return;
                }

                const standarProduk = standarMap[productId];

                if (!standarProduk) {
                    return;
                }

                $('.standar-value').each(function() {
                    const sampling = $(this).attr('data-sampling');
                    const field = $(this).attr('data-field');
                    const standarSampling = standarProduk[sampling];

                    if (standarSampling) {
                        $(this).text(formatAngka(standarSampling[field]));
                    }
                });
            }

            function loadProductionBatches(date, selectedBatchId = '') {
                batchSelect.empty().append('<option value="">Memuat production batch...</option>');
                batchSelect.prop('disabled', true).trigger('change');
                resetInformasiProduksi();
                resetStandar();

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
                            let productId = '';

                            if (batch.product_id) {
                                productId = batch.product_id;
                            } else if (batch.product && batch.product.id) {
                                productId = batch.product.id;
                            }

                            batchSelect.append(
                                $('<option>', {
                                    value: batch.id,
                                    text: kodeBatch + ' - ' + productName +
                                        ' - Shift ' + shift
                                }).attr('data-product', productName)
                                .attr('data-product-id', productId)
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
                        resetStandar();
                        console.error('Gagal mengambil production batch:', xhr.responseText);
                    }
                });
            }

            batchSelect.on('change', function() {
                const selectedOption = $(this).find('option:selected');

                if (!selectedOption.val()) {
                    resetInformasiProduksi();
                    resetStandar();
                    return;
                }

                $('#batch_product').text(selectedOption.attr('data-product') || '-');
                $('#batch_code').text(selectedOption.attr('data-kode-batch') || '-');
                $('#batch_shift').text(selectedOption.attr('data-shift') ? 'Shift ' + selectedOption.attr(
                    'data-shift') : '-');

                tampilkanStandar(selectedOption.attr('data-product-id'));
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
