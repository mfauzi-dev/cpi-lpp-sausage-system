@extends('layouts.master')

@section('title', 'Edit Produksi Bahan Baku')

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
                    Edit
                </div>
            </div>
        </div>

        <div class="section-lead">
            Perbarui data penggunaan bahan baku untuk production batch terkait.
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

            <form action="{{ route('operator.produksi-bahan-baku.update', $produksi->id) }}" method="POST"
                id="produksiForm">
                @csrf
                @method('PUT')

                {{-- Production batch sudah ditetapkan saat create, jadi dikunci (hidden input) --}}
                <input type="hidden" name="production_batch_id"
                    value="{{ old('production_batch_id', $produksi->production_batch_id) }}">

                {{-- INFORMASI PRODUKSI --}}
                <div class="card mb-4">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">1</span>
                            Informasi Produksi
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">
                                        Kode Batch
                                    </div>

                                    <div class="info-value">
                                        {{ $produksi->productionBatch->kode_batch ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">
                                        Tanggal Produksi
                                    </div>

                                    <div class="info-value">
                                        {{ optional($produksi->productionBatch->tanggal)->format('d-m-Y') ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">
                                        Product
                                    </div>

                                    <div class="info-value">
                                        {{ $produksi->productionBatch->product->nama ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">
                                        Shift
                                    </div>

                                    <div class="info-value">
                                        {{ $produksi->productionBatch->shift ?? '-' }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="filter-label">
                                        Penggunaan (Kg)
                                    </label>

                                    <input type="number" step="0.01" min="0" name="penggunaan" id="penggunaan"
                                        class="form-control" value="{{ old('penggunaan', $produksi->penggunaan) }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="filter-label">
                                        Total Bahan Baku (Kg)
                                    </label>

                                    <input type="text" id="total_display" class="form-control"
                                        value="{{ number_format($produksi->total, 2) }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="filter-label">
                                        Sisa (Kg)
                                    </label>

                                    <input type="text" id="sisa_display" class="form-control"
                                        value="{{ number_format($produksi->sisa, 2) }}" readonly>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- DATA BAHAN BAKU --}}
                <div class="card card-accent mb-4" id="item-card">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">2</span>
                            Data Bahan Baku
                        </h4>
                    </div>

                    <div class="card-body p-0">

                        <div class="d-flex justify-content-end p-3 pb-0">
                            <button type="button" id="btnBulkRemoveRow" class="btn btn-danger btn-sm" disabled>
                                <i class="fas fa-trash mr-1"></i>
                                Hapus Baris Terpilih
                            </button>
                        </div>

                        <div class="table-responsive">

                            <table class="table table-bordered table-wide" id="itemTable">

                                <thead>
                                    <tr>
                                        <th width="40" class="text-center">
                                            <input type="checkbox" id="checkAllRows">
                                        </th>
                                        <th width="60" class="text-center">No</th>
                                        <th>Bahan Baku</th>
                                        <th>Formula</th>
                                        <th>Kode Batch</th>
                                        <th>Best Before</th>
                                        <th>Total (Kg)</th>
                                        <th>Suhu RM</th>
                                        <th width="90" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody id="item-table-body">

                                    @foreach ($produksi->items as $index => $item)
                                        <tr data-row-index="{{ $index }}">

                                            <td class="text-center align-middle">
                                                <input type="checkbox" class="row-checkbox">
                                            </td>

                                            <td class="text-center align-middle nomor">
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                <select name="items[{{ $index }}][bahan_baku_id]"
                                                    class="form-control select2 bahan-baku" required>

                                                    <option value="">Pilih Bahan Baku</option>

                                                    @foreach ($bahanBakus as $bahanBaku)
                                                        <option value="{{ $bahanBaku->id }}"
                                                            {{ $item->bahan_baku_id == $bahanBaku->id ? 'selected' : '' }}>
                                                            {{ $bahanBaku->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </td>

                                            <td>
                                                <select name="items[{{ $index }}][product_formula_id]"
                                                    class="form-control select2 formula">

                                                    <option value="">- Tanpa Formula -</option>

                                                    @foreach ($formulas as $formula)
                                                        @if ($formula->bahan_baku_id == $item->bahan_baku_id)
                                                            <option value="{{ $formula->id }}"
                                                                {{ $item->product_formula_id == $formula->id ? 'selected' : '' }}>
                                                                {{ $formula->bahanBaku->name ?? '-' }}
                                                                (x{{ $formula->multiplier }} - {{ $formula->qty }})
                                                            </option>
                                                        @endif
                                                    @endforeach

                                                </select>
                                            </td>

                                            <td>
                                                <input type="text" name="items[{{ $index }}][kode_batch]"
                                                    class="form-control" placeholder="Kode batch"
                                                    value="{{ $item->kode_batch }}">
                                            </td>

                                            <td>
                                                <input type="date" name="items[{{ $index }}][best_before]"
                                                    class="form-control"
                                                    value="{{ optional($item->best_before)->format('Y-m-d') }}">
                                            </td>

                                            <td>
                                                <input type="number" step="0.001" min="0"
                                                    name="items[{{ $index }}][total_kg]"
                                                    class="form-control total-kg" placeholder="Total"
                                                    value="{{ $item->total_kg }}">
                                            </td>

                                            <td>
                                                <input type="number" step="0.1"
                                                    name="items[{{ $index }}][suhu_rm]" class="form-control"
                                                    placeholder="Suhu" value="{{ $item->suhu_rm }}">
                                            </td>

                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-outline-danger btn-sm removeRow"
                                                    title="Hapus Baris">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

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

                                <a href="{{ route('operator.produksi-bahan-baku.detail', $produksi->id) }}"
                                    class="btn btn-ghost">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Kembali
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>
                                    Simpan Perubahan
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

            let bahanBakuList = @json($bahanBakus);
            let formulaList = @json($formulas);
            let rowIndex = {{ $produksi->items->count() }};

            const oldItems = @json(old('items', []));

            function buildBahanBakuOptions(selectedId = '') {

                let options = '<option value="">Pilih Bahan Baku</option>';

                bahanBakuList.forEach(function(bahanBaku) {

                    const selected = String(bahanBaku.id) === String(selectedId) ? 'selected' : '';

                    options += `<option value="${bahanBaku.id}" ${selected}>${bahanBaku.name}</option>`;

                });

                return options;
            }

            function buildFormulaOptions(bahanBakuId, selectedId = '') {

                let options = '<option value="">- Tanpa Formula -</option>';

                formulaList
                    .filter(function(formula) {
                        return String(formula.bahan_baku_id) === String(bahanBakuId);
                    })
                    .forEach(function(formula) {

                        const selected = String(formula.id) === String(selectedId) ? 'selected' : '';
                        const name = formula.bahan_baku && formula.bahan_baku.name ?
                            formula.bahan_baku.name :
                            '-';

                        options +=
                            `<option value="${formula.id}" ${selected}>${name} (x${formula.multiplier} - ${formula.qty})</option>`;

                    });

                return options;
            }

            function appendItemRow(data = {}, index) {

                const bahanBakuId = data.bahan_baku_id ?? '';
                const formulaId = data.product_formula_id ?? '';
                const kodeBatch = data.kode_batch ?? '';
                const bestBefore = data.best_before ?? '';
                const totalKg = data.total_kg ?? '';
                const suhuRm = data.suhu_rm ?? '';

                const html = `
            <tr data-row-index="${index}">

                <td class="text-center align-middle">
                    <input type="checkbox" class="row-checkbox">
                </td>

                <td class="text-center align-middle nomor"></td>

                <td>
                    <select name="items[${index}][bahan_baku_id]" class="form-control select2 bahan-baku" required>
                        ${buildBahanBakuOptions(bahanBakuId)}
                    </select>
                </td>

                <td>
                    <select name="items[${index}][product_formula_id]" class="form-control select2 formula">
                        ${buildFormulaOptions(bahanBakuId, formulaId)}
                    </select>
                </td>

                <td>
                    <input type="text" name="items[${index}][kode_batch]" class="form-control" placeholder="Kode batch" value="${kodeBatch}">
                </td>

                <td>
                    <input type="date" name="items[${index}][best_before]" class="form-control" value="${bestBefore}">
                </td>

                <td>
                    <input type="number" step="0.001" min="0" name="items[${index}][total_kg]" class="form-control total-kg" placeholder="Total" value="${totalKg}">
                </td>

                <td>
                    <input type="number" step="0.1" name="items[${index}][suhu_rm]" class="form-control" placeholder="Suhu" value="${suhuRm}">
                </td>

                <td class="text-center align-middle">
                    <button type="button" class="btn btn-outline-danger btn-sm removeRow" title="Hapus Baris">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>

            </tr>
        `;

                $('#item-table-body').append(html);

                $('#item-table-body tr:last .select2').select2({
                    width: '100%'
                });

                renumberRows();
                recalculateTotal();
                updateBulkRemoveButton();
            }

            function renumberRows() {

                $('#item-table-body tr').each(function(index) {
                    $(this).find('.nomor').text(index + 1);
                });

            }

            function recalculateTotal() {

                let total = 0;

                $('.total-kg').each(function() {

                    const val = parseFloat($(this).val());

                    if (!isNaN(val)) {
                        total += val;
                    }

                });

                const penggunaan = parseFloat($('#penggunaan').val()) || 0;
                const sisa = total - penggunaan;

                $('#total_display').val(total.toFixed(2));
                $('#sisa_display').val(sisa.toFixed(2));
            }

            function updateBulkRemoveButton() {

                const checked = $('.row-checkbox:checked').length;
                const total = $('.row-checkbox').length;

                $('#btnBulkRemoveRow').prop('disabled', checked === 0);

                $('#checkAllRows').prop('checked', total > 0 && checked === total);
                $('#checkAllRows').prop('indeterminate', checked > 0 && checked < total);
            }

            // Jika ada old input karena validasi gagal, pakai itu, timpa data dari Blade
            if (oldItems && Object.keys(oldItems).length > 0) {

                $('#item-table-body').empty();

                Object.keys(oldItems).forEach(function(index) {
                    appendItemRow(oldItems[index], parseInt(index));
                });

                rowIndex = Math.max(...Object.keys(oldItems).map(Number)) + 1;

                renumberRows();
            }

            $(document).on('change', '.bahan-baku', function() {

                const row = $(this).closest('tr');
                const bahanBakuId = $(this).val();
                const formulaSelect = row.find('.formula');

                formulaSelect.html(buildFormulaOptions(bahanBakuId)).trigger('change');

            });

            $(document).on('input', '.total-kg, #penggunaan', function() {
                recalculateTotal();
            });

            $('#btnAddRow').on('click', function() {

                appendItemRow({}, rowIndex);
                rowIndex++;

            });

            $(document).on('click', '.removeRow', function() {

                const rows = $('#item-table-body tr');

                if (rows.length <= 1) {
                    alert('Minimal harus ada 1 baris.');
                    return;
                }

                $(this).closest('tr').remove();

                renumberRows();
                recalculateTotal();
                updateBulkRemoveButton();

            });

            // --- Bulk remove baris ---
            $(document).on('change', '.row-checkbox', function() {
                updateBulkRemoveButton();
            });

            $('#checkAllRows').on('change', function() {
                $('.row-checkbox').prop('checked', $(this).is(':checked'));
                updateBulkRemoveButton();
            });

            $('#btnBulkRemoveRow').on('click', function() {

                const totalRows = $('#item-table-body tr').length;
                const checkedRows = $('.row-checkbox:checked').length;

                if (checkedRows === 0) {
                    return;
                }

                if (checkedRows >= totalRows) {
                    alert('Minimal harus ada 1 baris yang tersisa.');
                    return;
                }

                if (!confirm('Yakin ingin menghapus ' + checkedRows + ' baris terpilih?')) {
                    return;
                }

                $('.row-checkbox:checked').each(function() {
                    $(this).closest('tr').remove();
                });

                renumberRows();
                recalculateTotal();
                updateBulkRemoveButton();

            });

            $('#produksiForm').on('submit', function(e) {

                const total = parseFloat($('#total_display').val()) || 0;
                const penggunaan = parseFloat($('#penggunaan').val()) || 0;

                if (penggunaan > total) {
                    e.preventDefault();
                    alert('Penggunaan tidak boleh melebihi total bahan baku.');
                }

            });

            recalculateTotal();
            updateBulkRemoveButton();

        });
    </script>
@endpush
