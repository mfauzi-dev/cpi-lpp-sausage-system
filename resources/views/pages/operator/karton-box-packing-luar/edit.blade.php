@extends('layouts.master')

@section('title', 'Edit Karton Box Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Karton Box Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.karton-box-packing-luar.index') }}">Karton Box Packing Luar</a>
                </div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-lead">
            Perbarui data karton box packing luar untuk production batch terkait.
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

            <form action="{{ route('operator.karton-box-packing-luar.update', $productionBatch->id) }}" method="POST"
                id="kartonBoxForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="production_batch_id"
                    value="{{ old('production_batch_id', $productionBatch->id) }}">

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
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value">{{ $productionBatch->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Tanggal Produksi</div>
                                    <div class="info-value">
                                        {{ optional($productionBatch->tanggal)->format('d-m-Y') ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Product</div>
                                    <div class="info-value">{{ $productionBatch->product->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value">{{ $productionBatch->shift ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4" id="item-card">
                    <div class="card-header">
                        <h4>
                            <span class="step-badge">2</span>
                            Data Karton Box Packing Luar
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
                                        <th>Jenis Karton Box</th>
                                        <th>QTY Box</th>
                                        <th>Pemakaian</th>
                                        <th>Sisa</th>
                                        <th>Reject</th>
                                        <th width="90" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="item-table-body">
                                    @foreach ($rows as $index => $row)
                                        <tr data-row-index="{{ $index }}">
                                            <td class="text-center align-middle">
                                                <input type="checkbox" class="row-checkbox">
                                            </td>
                                            <td class="text-center align-middle nomor">
                                                {{ $index + 1 }}
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][jenis_karton_box]"
                                                    class="form-control" placeholder="Jenis karton box"
                                                    value="{{ $row->jenis_karton_box }}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $index }}][qty_box]" class="form-control qty-box"
                                                    placeholder="QTY Box" value="{{ $row->qty_box }}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $index }}][pemakaian]"
                                                    class="form-control pemakaian" placeholder="Pemakaian"
                                                    value="{{ $row->pemakaian }}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $index }}][sisa]" class="form-control sisa"
                                                    placeholder="Sisa" value="{{ $row->sisa }}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $index }}][reject]" class="form-control reject"
                                                    placeholder="Reject" value="{{ $row->reject }}">
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
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Total</td>
                                        <td class="font-weight-bold">
                                            <span id="totalQty">0,00</span>
                                        </td>
                                        <td class="font-weight-bold">
                                            <span id="totalPemakaian">0,00</span>
                                        </td>
                                        <td class="font-weight-bold">
                                            <span id="totalSisa">0,00</span>
                                        </td>
                                        <td class="font-weight-bold">
                                            <span id="totalReject">0,00</span>
                                        </td>
                                        <td></td>
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
                                <a href="{{ route('operator.karton-box-packing-luar.detail', $productionBatch->id) }}"
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
            let rowIndex = {{ $rows->count() }};
            const oldItems = @json(old('items', []));

            function formatNumber(value, decimal = 2) {
                return Number(value).toLocaleString('id-ID', {
                    minimumFractionDigits: decimal,
                    maximumFractionDigits: decimal
                });
            }

            function appendItemRow(data = {}, index) {
                const html = `
                    <tr data-row-index="${index}">
                        <td class="text-center align-middle">
                            <input type="checkbox" class="row-checkbox">
                        </td>
                        <td class="text-center align-middle nomor"></td>
                        <td>
                            <input type="text" name="items[${index}][jenis_karton_box]" class="form-control"
                                placeholder="Jenis karton box" value="${data.jenis_karton_box ?? ''}">
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0" name="items[${index}][qty_box]"
                                class="form-control qty-box" placeholder="QTY Box" value="${data.qty_box ?? ''}">
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0" name="items[${index}][pemakaian]"
                                class="form-control pemakaian" placeholder="Pemakaian" value="${data.pemakaian ?? ''}">
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0" name="items[${index}][sisa]"
                                class="form-control sisa" placeholder="Sisa" value="${data.sisa ?? ''}">
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0" name="items[${index}][reject]"
                                class="form-control reject" placeholder="Reject" value="${data.reject ?? ''}">
                        </td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-outline-danger btn-sm removeRow" title="Hapus Baris">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#item-table-body').append(html);
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
                let totalQty = 0;
                let totalPemakaian = 0;
                let totalSisa = 0;
                let totalReject = 0;

                $('.qty-box').each(function() {
                    totalQty += parseFloat($(this).val()) || 0;
                });

                $('.pemakaian').each(function() {
                    totalPemakaian += parseFloat($(this).val()) || 0;
                });

                $('.sisa').each(function() {
                    totalSisa += parseFloat($(this).val()) || 0;
                });

                $('.reject').each(function() {
                    totalReject += parseFloat($(this).val()) || 0;
                });

                $('#totalQty').text(formatNumber(totalQty));
                $('#totalPemakaian').text(formatNumber(totalPemakaian));
                $('#totalSisa').text(formatNumber(totalSisa));
                $('#totalReject').text(formatNumber(totalReject));
            }

            function updateBulkRemoveButton() {
                const checked = $('.row-checkbox:checked').length;
                const total = $('.row-checkbox').length;

                $('#btnBulkRemoveRow').prop('disabled', checked === 0);
                $('#checkAllRows').prop('checked', total > 0 && checked === total);
                $('#checkAllRows').prop('indeterminate', checked > 0 && checked < total);
            }

            if (oldItems && Object.keys(oldItems).length > 0) {
                $('#item-table-body').empty();

                Object.keys(oldItems).forEach(function(index) {
                    appendItemRow(oldItems[index], parseInt(index));
                });

                rowIndex = Math.max(...Object.keys(oldItems).map(Number)) + 1;
            }

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

            $(document).on('input', '.qty-box, .pemakaian, .sisa, .reject', function() {
                recalculateTotal();
            });

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

            recalculateTotal();
            updateBulkRemoveButton();
        });
    </script>
@endpush
