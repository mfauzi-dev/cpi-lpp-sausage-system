@extends('layouts.master')

@section('title', 'Detail Karton Box Packing Luar')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Karton Box Packing Luar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.karton-box-packing-luar.index') }}">Karton Box Packing Luar</a>
                </div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <p class="section-lead">
            Detail pencatatan penggunaan karton box packing luar berdasarkan production batch terkait.
        </p>

        <div class="section-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
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

            <div class="card mb-4">
                <div class="card-header">
                    <h4>
                        <span class="step-badge">1</span>
                        Informasi Produksi
                    </h4>
                </div>
                <div class="card-body">
                    <div class="batch-highlight">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="batch-label">Production Batch</div>
                                <div class="batch-number">
                                    {{ $productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    {{ $productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number batch-date">
                                    {{ $productionBatch->tanggal ? $productionBatch->tanggal->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Product</div>
                                <div class="info-value">{{ $productionBatch->product->name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total QTY Box</div>
                                    <div class="stat-value">
                                        {{ number_format($rows->sum('qty_box'), 2, ',', '.') }} Box
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Pemakaian</div>
                                    <div class="stat-value">
                                        {{ number_format($rows->sum('pemakaian'), 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Sisa</div>
                                    <div class="stat-value">
                                        {{ number_format($rows->sum('sisa'), 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Total Reject</div>
                                    <div class="stat-value">
                                        {{ number_format($rows->sum('reject'), 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4>
                        <span class="step-badge">2</span>
                        Data Karton Box Packing Luar
                    </h4>
                </div>
                <div class="card-body">
                    <form id="bulkDeleteItemForm"
                        action="{{ route('operator.karton-box-packing-luar.item.bulk-destroy') }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus data karton box yang dipilih?')">
                        @csrf
                        <input type="hidden" name="production_batch_id" value="{{ $productionBatch->id }}">
                    </form>

                    @if ($rows->count() > 0)
                        <div class="d-flex justify-content-end mb-2">
                            <button type="submit" form="bulkDeleteItemForm" id="btnBulkDeleteItem"
                                class="btn btn-danger btn-sm" disabled>
                                <i class="fas fa-trash mr-1"></i>
                                Hapus Terpilih
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-wide">
                            <thead>
                                <tr>
                                    <th width="40" class="text-center">
                                        <input type="checkbox" class="check-item-all">
                                    </th>
                                    <th width="60" class="text-center">No</th>
                                    <th>Jenis Karton Box</th>
                                    <th class="text-right">QTY Box</th>
                                    <th class="text-right">Pemakaian</th>
                                    <th class="text-right">Sisa</th>
                                    <th class="text-right">Reject</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rows as $index => $row)
                                    <tr>
                                        <td class="text-center align-middle">
                                            <input type="checkbox" name="ids[]" value="{{ $row->id }}"
                                                class="item-checkbox" form="bulkDeleteItemForm">
                                        </td>
                                        <td class="text-center font-weight-bold">
                                            {{ $index + 1 }}
                                        </td>
                                        <td>
                                            {{ $row->jenis_karton_box ?? '-' }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($row->qty_box ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($row->pemakaian ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($row->sisa ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($row->reject ?? 0, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="fas fa-box-open d-block"></i>
                                                <div>Belum ada data karton box packing luar.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($rows->count() > 0)
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Total</td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($rows->sum('qty_box'), 2, ',', '.') }}
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($rows->sum('pemakaian'), 2, ',', '.') }}
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($rows->sum('sisa'), 2, ',', '.') }}
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($rows->sum('reject'), 2, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-final">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <div class="info-label mb-1">Total QTY Karton Box</div>
                            <div class="stat-value">
                                {{ number_format($rows->sum('qty_box'), 2, ',', '.') }} Box
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <a href="{{ route('operator.karton-box-packing-luar.index') }}" class="btn btn-ghost mr-1">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>
                            <a href="{{ route('operator.karton-box-packing-luar.edit', $productionBatch->id) }}"
                                class="btn btn-primary mr-1">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <form action="{{ route('operator.karton-box-packing-luar.destroy', $productionBatch->id) }}"
                                method="POST" id="deleteForm" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="btnDelete" class="btn btn-danger">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('deleteForm').addEventListener('submit', function(event) {
                const confirmed = confirm(
                    'Yakin ingin menghapus seluruh data karton box packing luar pada production batch ini?'
                );
                if (!confirmed) {
                    event.preventDefault();
                }
            });

            const checkAllItem = document.querySelector('.check-item-all');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const btnBulkDeleteItem = document.getElementById('btnBulkDeleteItem');

            function updateBulkItemButton() {
                if (!btnBulkDeleteItem) return;

                const checked = document.querySelectorAll('.item-checkbox:checked');
                btnBulkDeleteItem.disabled = checked.length === 0;

                if (checkAllItem) {
                    checkAllItem.checked = itemCheckboxes.length > 0 && checked.length === itemCheckboxes.length;
                    checkAllItem.indeterminate = checked.length > 0 && checked.length < itemCheckboxes.length;
                }
            }

            if (checkAllItem) {
                checkAllItem.addEventListener('change', function() {
                    itemCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = checkAllItem.checked;
                    });
                    updateBulkItemButton();
                });
            }

            itemCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateBulkItemButton);
            });

            updateBulkItemButton();
        });
    </script>
@endpush
