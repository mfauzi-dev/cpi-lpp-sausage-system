@extends('layouts.master')

@section('title', 'Tambah Produksi Bahan Baku')

@section('content')

    <div class="page-section">

        <div class="section-header">
            <h1>Produksi Bahan Baku</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.produksi-bahan-baku.index') }}">
                        Produksi Bahan Baku
                    </a>
                </div>

                <div class="breadcrumb-item active">
                    Tambah
                </div>
            </div>
        </div>

        <div class="section-lead">
            Tambahkan data bahan baku yang dipakai pada production batch.
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

            <form action="{{ route('operator.produksi-bahan-baku.store') }}" method="POST" id="produksiForm">

                @csrf

                <div class="card mb-4">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">1</span>
                            Informasi Produksi
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="filter-label">
                                        Tanggal Produksi
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        value="{{ old('tanggal') }}" required>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="filter-label">
                                        Production Batch
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="production_batch_id" id="production_batch_id" class="form-control select2"
                                        required disabled>
                                        <option value="">Pilih tanggal terlebih dahulu</option>
                                    </select>
                                </div>
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

                <div class="card card-accent mb-4" id="bahan-card" style="display: none;">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">2</span>
                            Data Bahan Baku
                        </h4>
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-bordered table-wide" id="bahanTable">

                                <thead>
                                    <tr>
                                        <th width="70" class="text-center">No</th>
                                        <th>Bahan Baku</th>
                                        <th>Formula</th>
                                        <th>Kode Batch</th>
                                        <th>Best Before</th>
                                        <th>Total (Kg)</th>
                                        <th>Suhu RM (°C)</th>
                                        <th width="100" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody id="bahan-table-body"></tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Total</td>
                                        <td colspan="3" class="font-weight-bold" id="total_kg_text">0,00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold align-middle">
                                            Penggunaan
                                        </td>
                                        <td colspan="3">
                                            <input type="number" step="0.001" min="0" name="penggunaan"
                                                id="penggunaan" class="form-control" placeholder="Penggunaan (Kg)"
                                                value="{{ old('penggunaan') }}">
                                            <small class="text-danger" id="penggunaan_warning" style="display: none;">
                                                Penggunaan melebihi total bahan baku.
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Sisa</td>
                                        <td colspan="3" class="font-weight-bold" id="sisa_kg_text">0,00</td>
                                    </tr>
                                </tfoot>

                            </table>

                        </div>

                    </div>

                    <div class="card-footer bg-white border-top">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <button type="button" id="btnAddRow" class="btn btn-add mb-2 mb-md-0">
                                <i class="fas fa-plus mr-1"></i>
                                Tambah Baris
                            </button>

                            <div class="action-buttons">

                                <a href="{{ route('operator.produksi-bahan-baku.index') }}" class="btn btn-ghost">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Kembali
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>
                                    Simpan
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.select2').select2({
                width: '100%'
            });

            const bahanBakus = @json($bahanBakus->map(fn($b) => ['id' => $b->id, 'name' => $b->name]));
            const oldItems = @json(old('items', []));

            let formulas = [];
            let rowIndex = 0;

            function resetBatchInfo() {
                $('#batch_product').text('-');
                $('#batch_code').text('-');
                $('#batch_shift').text('-');
            }

            // ===== Tanggal -> Production Batch =====
            $('#tanggal').on('change', function() {

                const date = $(this).val();
                const batchSelect = $('#production_batch_id');

                resetBatchInfo();
                $('#bahan-card').hide();

                if (!date) {
                    batchSelect
                        .empty()
                        .append('<option value="">Pilih tanggal terlebih dahulu</option>')
                        .prop('disabled', true)
                        .trigger('change');

                    return;
                }

                batchSelect
                    .prop('disabled', true)
                    .empty()
                    .append('<option value="">Memuat production batch...</option>')
                    .trigger('change');

                $.ajax({
                    url: `{{ route('operator.production-batch.by-date', ':date') }}`.replace(
                        ':date', date),
                    type: 'GET',

                    success: function(response) {

                        batchSelect
                            .empty()
                            .append('<option value="">Pilih Production Batch</option>');

                        if (response.length === 0) {
                            batchSelect
                                .empty()
                                .append(
                                    '<option value="">Tidak ada production batch pada tanggal ini</option>'
                                )
                                .prop('disabled', true)
                                .trigger('change');

                            return;
                        }

                        response.forEach(function(batch) {
                            const productName = batch.product ? batch.product.name :
                                '-';

                            batchSelect.append(`
                                <option
                                    value="${batch.id}"
                                    data-product="${productName}"
                                    data-kode_batch="${batch.kode_batch ?? '-'}"
                                    data-shift="${batch.shift ?? '-'}"
                                >
                                    ${batch.kode_batch} - ${productName}
                                </option>
                            `);
                        });

                        batchSelect.prop('disabled', false).trigger('change');

                        const oldBatchId = '{{ old('production_batch_id') }}';

                        if (oldBatchId) {
                            batchSelect.val(oldBatchId).trigger('change');
                        }
                    },

                    error: function() {
                        batchSelect
                            .empty()
                            .append('<option value="">Gagal memuat production batch</option>')
                            .prop('disabled', true)
                            .trigger('change');
                    }
                });

            });

            // ===== Production Batch -> info + formula =====
            $('#production_batch_id').on('change', function() {

                const batchId = $(this).val();
                const selected = $(this).find(':selected');

                if (!batchId) {
                    resetBatchInfo();
                    $('#bahan-card').hide();

                    return;
                }

                $('#batch_product').text(selected.data('product') || '-');
                $('#batch_code').text(selected.data('kode_batch') || '-');
                $('#batch_shift').text(selected.data('shift') || '-');

                $('#bahan-card').show();

                $.ajax({
                    url: `{{ route('produksi-bahan-baku.get-formulas', ':id') }}`.replace(':id',
                        batchId),
                    type: 'GET',

                    success: function(response) {

                        formulas = response;

                        if ($('#bahan-table-body tr').length === 0) {

                            if (Object.keys(oldItems).length > 0) {
                                Object.keys(oldItems).forEach(function(index) {
                                    appendRow(oldItems[index], parseInt(index));
                                });

                                rowIndex = Math.max(...Object.keys(oldItems).map(Number)) + 1;
                            } else {
                                appendRow({}, rowIndex);
                                rowIndex++;
                            }

                        } else {
                            refreshFormulaSelects();
                        }

                        calculate();
                    },

                    error: function() {
                        formulas = [];
                        alert('Gagal memuat formula produk.');
                    }
                });

            });

            // ===== Builder opsi =====
            function buildBahanOptions(selectedId = '') {

                let options = '<option value="">Pilih Bahan Baku</option>';

                bahanBakus.forEach(function(bahan) {
                    const selected = String(bahan.id) === String(selectedId) ? 'selected' : '';

                    options += `<option value="${bahan.id}" ${selected}>${bahan.name}</option>`;
                });

                return options;
            }

            // Formula yang tampil hanya milik bahan baku yang dipilih di baris tsb
            function buildFormulaOptions(bahanId, selectedId = '') {

                let options = '<option value="">- Tanpa formula -</option>';

                formulas
                    .filter(f => String(f.bahan_baku_id) === String(bahanId))
                    .forEach(function(f) {
                        const selected = String(f.id) === String(selectedId) ? 'selected' : '';
                        const qty = String(f.qty).replace('.', ',');

                        options +=
                            `<option value="${f.id}" ${selected}>Formula ${f.multiplier} (${qty})</option>`;
                    });

                return options;
            }

            function refreshFormulaSelects() {

                $('#bahan-table-body tr').each(function() {

                    const bahanId = $(this).find('.bahan').val();
                    const formulaSelect = $(this).find('.formula');
                    const current = formulaSelect.val();

                    formulaSelect.html(buildFormulaOptions(bahanId, current)).trigger('change.select2');

                });

            }

            // ===== Baris =====
            function appendRow(data = {}, index) {

                const html = `
                    <tr data-row-index="${index}">

                        <td class="text-center align-middle nomor"></td>

                        <td>
                            <select name="items[${index}][bahan_baku_id]"
                                class="form-control select2 bahan" required>
                                ${buildBahanOptions(data.bahan_baku_id ?? '')}
                            </select>
                        </td>

                        <td>
                            <select name="items[${index}][product_formula_id]"
                                class="form-control select2 formula">
                                ${buildFormulaOptions(data.bahan_baku_id ?? '', data.product_formula_id ?? '')}
                            </select>
                        </td>

                        <td>
                            <input type="text" name="items[${index}][kode_batch]"
                                class="form-control" placeholder="Kode batch"
                                value="${data.kode_batch ?? ''}">
                        </td>

                        <td>
                            <input type="date" name="items[${index}][best_before]"
                                class="form-control"
                                value="${data.best_before ?? ''}">
                        </td>

                        <td>
                            <input type="number" step="0.001" min="0"
                                name="items[${index}][total_kg]"
                                class="form-control total-kg" placeholder="Kg"
                                value="${data.total_kg ?? ''}">
                        </td>

                        <td>
                            <input type="number" step="0.1"
                                name="items[${index}][suhu_rm]"
                                class="form-control" placeholder="Suhu"
                                value="${data.suhu_rm ?? ''}">
                        </td>

                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-outline-danger btn-sm removeRow"
                                title="Hapus Baris">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>

                    </tr>
                `;

                $('#bahan-table-body').append(html);

                $('#bahan-table-body tr:last .select2').select2({
                    width: '100%'
                });

                renumberRows();
            }

            // Ganti bahan baku -> opsi formula ikut berubah
            $(document).on('change', '.bahan', function() {

                $(this).closest('tr').find('.formula')
                    .html(buildFormulaOptions($(this).val()))
                    .trigger('change.select2');

            });

            $(document).on('input', '.total-kg, #penggunaan', calculate);

            $('#btnAddRow').on('click', function() {

                appendRow({}, rowIndex);
                rowIndex++;

            });

            $(document).on('click', '.removeRow', function() {

                if ($('#bahan-table-body tr').length <= 1) {
                    alert('Minimal harus ada 1 baris.');

                    return;
                }

                $(this).closest('tr').remove();

                renumberRows();
                calculate();

            });

            function renumberRows() {

                $('#bahan-table-body tr').each(function(index) {
                    $(this).find('.nomor').text(index + 1);
                });

            }

            // ===== Hitung Total & Sisa =====
            function formatNumber(value) {
                return value.toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function calculate() {

                let total = 0;

                $('.total-kg').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });

                const penggunaan = parseFloat($('#penggunaan').val()) || 0;
                const sisa = total - penggunaan;

                $('#total_kg_text').text(formatNumber(total));
                $('#sisa_kg_text').text(formatNumber(sisa));

                $('#penggunaan_warning').toggle(penggunaan > total);
            }

            @if (old('tanggal'))
                $('#tanggal').trigger('change');
            @endif

        });
    </script>
@endpush
