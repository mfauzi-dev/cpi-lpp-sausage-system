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

                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value">
                                        {{ $produksi->productionBatch->kode_batch ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Tanggal Produksi</div>
                                    <div class="info-value">
                                        {{ optional($produksi->productionBatch->tanggal)->format('d-m-Y') ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Product</div>
                                    <div class="info-value">
                                        {{ $produksi->productionBatch->product->nama ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value">
                                        {{ $produksi->productionBatch->shift ?? '-' }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- DATA BAHAN BAKU --}}
                <div class="card card-accent mb-4" id="bahan-card">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">2</span>
                            Data Bahan Baku
                        </h4>
                    </div>

                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="filter-label">Pilih Formula</label>
                                    <select id="formula_picker" class="form-control select2">
                                        <option value="">Pilih Formula</option>
                                    </select>
                                    <small class="text-muted">
                                        Mengganti formula akan mengisi ulang tabel bahan baku di bawah.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-bordered table-wide" id="bahanTable">

                                <thead>
                                    <tr>
                                        <th width="70" class="text-center">No</th>
                                        <th>Bahan Baku</th>
                                        <th>Formula</th>
                                        <th>Total (Kg)</th>
                                        <th>Kode Batch</th>
                                        <th>Best Before</th>
                                        <th>Suhu RM (°C)</th>
                                        <th width="100" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody id="bahan-table-body">
                                    <tr id="empty-row">
                                        <td colspan="8" class="text-center text-muted">
                                            Pilih formula untuk menampilkan bahan baku.
                                        </td>
                                    </tr>
                                </tbody>

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
                                                value="{{ old('penggunaan', $produksi->penggunaan) }}">
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

                        <div class="d-flex justify-content-end align-items-center flex-wrap">

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

@php
    $bahanBakusJs = $bahanBakus
        ->map(function ($b) {
            return [
                'id' => $b->id,
                'name' => $b->name,
            ];
        })
        ->values();

    $formulasJs = $formulas
        ->map(function ($f) {
            return [
                'id' => $f->id,
                'bahan_baku_id' => $f->bahan_baku_id,
                'multiplier' => $f->multiplier,
                'total_kg' => $f->total_kg,
            ];
        })
        ->values();

    // total_kg sudah tidak lagi kolom di item (sekarang murni master
    // data di ProductFormula), jadi tidak diikutkan di sini.
    $currentItemsJs = $produksi->items
        ->map(function ($item) {
            return [
                'bahan_baku_id' => $item->bahan_baku_id,
                'product_formula_id' => $item->product_formula_id,
                'kode_batch' => $item->kode_batch,
                'best_before' => optional($item->best_before)->format('Y-m-d'),
                'suhu_rm' => $item->suhu_rm,
            ];
        })
        ->values();
@endphp

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.select2').select2({
                width: '100%'
            });

            const bahanBakus = @json($bahanBakusJs);
            const formulas = @json($formulasJs);

            // Data item saat ini (dari DB), dipakai kalau tidak ada old('items') akibat validasi gagal
            const currentItems = @json($currentItemsJs);

            let oldItems = @json(old('items', []));

            // ===== Daftar formula (nomor multiplier yang unik) =====
            function getMultipliers() {

                const result = [];

                formulas.forEach(function(f) {
                    if (result.indexOf(String(f.multiplier)) === -1) {
                        result.push(String(f.multiplier));
                    }
                });

                return result;
            }

            function buildFormulaPicker(multipliers) {

                let options = '<option value="">Pilih Formula</option>';

                multipliers.forEach(function(m) {
                    options += `<option value="${m}">Formula ${m}</option>`;
                });

                $('#formula_picker').html(options).trigger('change.select2');
            }

            // ===== Pilih formula -> semua bahan baku langsung muncul =====
            $('#formula_picker').on('change', function() {

                const multiplier = $(this).val();

                if (!multiplier) {
                    showEmptyMessage();
                    calculate();

                    return;
                }

                renderFormulaRows(multiplier);
                calculate();

            });

            function showEmptyMessage() {

                $('#bahan-table-body').html(`
                    <tr id="empty-row">
                        <td colspan="8" class="text-center text-muted">
                            Pilih formula untuk menampilkan bahan baku.
                        </td>
                    </tr>
                `);

            }

            // Semua bahan baku milik formula yang dipilih langsung muncul (kayak di create),
            // data yang sudah tersimpan (savedDataMap) otomatis "nempel" ke baris yang cocok.
            function renderFormulaRows(multiplier) {

                $('#bahan-table-body').empty();

                let index = 0;

                formulas.forEach(function(f) {

                    if (String(f.multiplier) !== String(multiplier)) {
                        return;
                    }

                    const existing = savedDataMap[String(f.id)] || {};

                    appendRow({
                        bahan_baku_id: f.bahan_baku_id,
                        product_formula_id: f.id,
                        kode_batch: existing.kode_batch,
                        best_before: existing.best_before,
                        suhu_rm: existing.suhu_rm
                    }, index);

                    index++;

                });

                // item tersimpan yang bahan bakunya tidak termasuk formula manapun di produk ini
                // (mis. ditambahkan manual tanpa formula di edit versi lama) tetap ditampilkan.
                // Total (Kg) baris ini otomatis 0 karena tidak ada ProductFormula yang menyertainya.
                leftoverItems.forEach(function(item) {
                    appendRow(item, index);
                    index++;
                });

                if (index === 0) {
                    showEmptyMessage();
                }

                renumberRows();
            }

            // ===== Cari nama bahan baku, label formula & total kg master =====
            function getBahanName(bahanId) {

                let name = '-';

                bahanBakus.forEach(function(b) {
                    if (String(b.id) === String(bahanId)) {
                        name = b.name;
                    }
                });

                return name;
            }

            function getFormulaLabel(formulaId) {

                let label = '- Tanpa Formula -';

                formulas.forEach(function(f) {
                    if (String(f.id) === String(formulaId)) {
                        const total = String(f.total_kg).replace('.', ',');
                        label = 'Formula ' + f.multiplier + ' (' + total + ' Kg)';
                    }
                });

                return label;
            }

            // total_kg sekarang murni master data di ProductFormula; item
            // tanpa product_formula_id yang cocok otomatis dapat 0.
            function getFormulaTotalKg(formulaId) {

                let total = 0;

                formulas.forEach(function(f) {
                    if (String(f.id) === String(formulaId)) {
                        total = parseFloat(f.total_kg) || 0;
                    }
                });

                return total;
            }

            // ===== Baris =====
            function appendRow(data = {}, index) {

                const totalKg = getFormulaTotalKg(data.product_formula_id);

                const html = `
                    <tr data-row-index="${index}">

                        <td class="text-center align-middle nomor"></td>

                        <td class="align-middle">
                            ${getBahanName(data.bahan_baku_id)}
                            <input type="hidden" name="items[${index}][bahan_baku_id]"
                                value="${data.bahan_baku_id ?? ''}">
                        </td>

                        <td class="align-middle">
                            ${getFormulaLabel(data.product_formula_id)}
                            <input type="hidden" name="items[${index}][product_formula_id]"
                                value="${data.product_formula_id ?? ''}">
                        </td>

                        <td class="align-middle text-right total-kg-cell" data-total-kg="${totalKg}">
                            ${formatNumber(totalKg)}
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

                renumberRows();
            }

            $(document).on('input', '#penggunaan', calculate);

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

                $('.total-kg-cell').each(function() {
                    total += parseFloat($(this).data('total-kg')) || 0;
                });

                const penggunaan = parseFloat($('#penggunaan').val()) || 0;
                const sisa = total - penggunaan;

                $('#total_kg_text').text(formatNumber(total));
                $('#sisa_kg_text').text(formatNumber(sisa));

                $('#penggunaan_warning').toggle(penggunaan > total);
            }

            // ===== Init =====
            buildFormulaPicker(getMultipliers());

            // Sumber data: old('items') kalau validasi gagal sebelumnya, kalau tidak ya item yang sudah tersimpan
            const sourceItems = (oldItems && Object.keys(oldItems).length > 0) ?
                Object.values(oldItems) :
                currentItems;

            // Petakan item per product_formula_id supaya bisa "ditempel" ke baris formula yang sesuai
            const savedDataMap = {};
            const leftoverItems = [];
            let initialMultiplier = '';

            sourceItems.forEach(function(item) {

                const formula = item.product_formula_id ?
                    formulas.find(function(f) {
                        return String(f.id) === String(item.product_formula_id);
                    }) :
                    null;

                if (formula) {
                    savedDataMap[String(formula.id)] = item;

                    if (!initialMultiplier) {
                        initialMultiplier = String(formula.multiplier);
                    }
                } else {
                    // tidak ada formula yang cocok (null atau sudah tidak ada di produk ini)
                    leftoverItems.push(item);
                }

            });

            if (initialMultiplier) {
                $('#formula_picker').val(initialMultiplier).trigger('change.select2');
                renderFormulaRows(initialMultiplier);
            } else if (leftoverItems.length > 0) {
                // semua item lama tanpa formula -> tampilkan apa adanya
                $('#bahan-table-body').empty();
                leftoverItems.forEach(function(item, idx) {
                    appendRow(item, idx);
                });
                renumberRows();
            } else {
                showEmptyMessage();
            }

            calculate();

            $('#produksiForm').on('submit', function(e) {

                const totalRows = $('#bahan-table-body tr[data-row-index]').length;

                if (totalRows === 0) {
                    e.preventDefault();
                    alert('Minimal harus ada 1 baris bahan baku.');
                    return;
                }

                let total = 0;
                $('.total-kg-cell').each(function() {
                    total += parseFloat($(this).data('total-kg')) || 0;
                });

                const penggunaan = parseFloat($('#penggunaan').val()) || 0;

                if (penggunaan > total) {
                    e.preventDefault();
                    alert('Penggunaan tidak boleh melebihi total bahan baku.');
                }

            });

        });
    </script>
@endpush
