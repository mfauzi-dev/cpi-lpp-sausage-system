@extends('layouts.master')

@section('title', 'Tambah Pengemasan Plastik Packing Dalam')

@section('content')

    <div class="page-section">

        <div class="section-header">
            <h1>Pengemasan Plastik Packing Dalam</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.pengemasan-plastik-packing-dalam.index') }}">
                        Pengemasan Plastik Packing Dalam
                    </a>
                </div>

                <div class="breadcrumb-item active">
                    Tambah
                </div>
            </div>
        </div>

        <div class="section-lead">
            Tambahkan data penggunaan plastik packing dalam pada production batch.
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

            <form action="{{ route('operator.pengemasan-plastik-packing-dalam.store') }}" method="POST"
                id="pengemasanForm">

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

                <div class="card card-accent mb-4" id="plastik-card" style="display: none;">

                    <div class="card-header">
                        <h4>
                            <span class="step-badge">2</span>
                            Data Plastik Packing Dalam
                        </h4>
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-bordered table-wide" id="plastikTable">

                                <thead>
                                    <tr>
                                        <th width="70" class="text-center">No</th>
                                        <th>Jenis Plastik</th>
                                        <th>No MD</th>
                                        <th>Qty Pack (Pcs)</th>
                                        <th>Pemakaian (Kg)</th>
                                        <th>Sisa (Kg)</th>
                                        <th>Reject Plastik (Kg)</th>
                                        <th width="100" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody id="plastik-table-body"></tbody>

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

                                <a href="{{ route('operator.pengemasan-plastik-packing-dalam.index') }}"
                                    class="btn btn-ghost">
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

            const oldItems = @json(old('items', []));

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
                $('#plastik-card').hide();

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

            // ===== Production Batch -> info + tabel plastik =====
            $('#production_batch_id').on('change', function() {

                const batchId = $(this).val();
                const selected = $(this).find(':selected');

                if (!batchId) {
                    resetBatchInfo();
                    $('#plastik-card').hide();

                    return;
                }

                $('#batch_product').text(selected.data('product') || '-');
                $('#batch_code').text(selected.data('kode_batch') || '-');
                $('#batch_shift').text(selected.data('shift') || '-');

                $('#plastik-card').show();

                if ($('#plastik-table-body tr').length === 0) {

                    if (Object.keys(oldItems).length > 0) {
                        Object.keys(oldItems).forEach(function(index) {
                            appendRow(oldItems[index], parseInt(index));
                        });

                        rowIndex = Math.max(...Object.keys(oldItems).map(Number)) + 1;
                    } else {
                        appendRow({}, rowIndex);
                        rowIndex++;
                    }

                }

            });

            // ===== Baris =====
            function appendRow(data = {}, index) {

                const html = `
                    <tr data-row-index="${index}">

                        <td class="text-center align-middle nomor"></td>

                        <td>
                            <input type="text" name="items[${index}][jenis_plastik]"
                                class="form-control" placeholder="Jenis plastik"
                                value="${data.jenis_plastik ?? ''}">
                        </td>

                        <td>
                            <input type="text" name="items[${index}][no_md]"
                                class="form-control" placeholder="No MD"
                                value="${data.no_md ?? ''}">
                        </td>

                        <td>
                            <input type="number" step="1" min="0"
                                name="items[${index}][qty_pack]"
                                class="form-control" placeholder="Pcs"
                                value="${data.qty_pack ?? ''}">
                        </td>

                        <td>
                            <input type="number" step="0.01" min="0"
                                name="items[${index}][pemakaian]"
                                class="form-control" placeholder="Kg"
                                value="${data.pemakaian ?? ''}">
                        </td>

                        <td>
                            <input type="number" step="0.01" min="0"
                                name="items[${index}][sisa]"
                                class="form-control" placeholder="Kg"
                                value="${data.sisa ?? ''}">
                        </td>

                        <td>
                            <input type="number" step="0.01" min="0"
                                name="items[${index}][reject_plastik]"
                                class="form-control" placeholder="Kg"
                                value="${data.reject_plastik ?? ''}">
                        </td>

                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-outline-danger btn-sm removeRow"
                                title="Hapus Baris">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>

                    </tr>
                `;

                $('#plastik-table-body').append(html);

                renumberRows();
            }

            $('#btnAddRow').on('click', function() {

                appendRow({}, rowIndex);
                rowIndex++;

            });

            $(document).on('click', '.removeRow', function() {

                if ($('#plastik-table-body tr').length <= 1) {
                    alert('Minimal harus ada 1 baris.');

                    return;
                }

                $(this).closest('tr').remove();

                renumberRows();

            });

            function renumberRows() {

                $('#plastik-table-body tr').each(function(index) {
                    $(this).find('.nomor').text(index + 1);
                });

            }

            @if (old('tanggal'))
                $('#tanggal').trigger('change');
            @endif

        });
    </script>
@endpush
