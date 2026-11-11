@extends('layouts.master')

@section('title', 'Formula - ' . $product->name)

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Formula: {{ $product->name }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.product.index') }}">
                        Produk
                    </a>
                </div>
                <div class="breadcrumb-item active">
                    Formula
                </div>
            </div>
        </div>

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

        <div class="mb-4 d-flex align-items-center flex-wrap" style="gap: .5rem;">
            <a href="{{ route('operator.product.index') }}" class="btn btn-ghost">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali ke Produk
            </a>

            <a href="{{ route('operator.product.formula.import') }}" class="btn btn-add">
                <i class="fas fa-file-import mr-1"></i>
                Import Formula
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>
                    <span class="step-badge">1</span>
                    Tambah Bahan Baku ke Formula
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('operator.product.formula.store', $product->id) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class="filter-label">Bahan Baku</label>
                            <select name="bahan_baku_id"
                                class="form-control select2 @error('bahan_baku_id') is-invalid @enderror">
                                <option value="">-- Pilih Bahan Baku --</option>
                                @foreach ($bahanBakus as $bb)
                                    <option value="{{ $bb->id }}"
                                        {{ old('bahan_baku_id') == $bb->id ? 'selected' : '' }}>
                                        {{ $bb->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bahan_baku_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="filter-label">Nomor Formula</label>
                            <input type="number" name="multiplier" min="1"
                                class="form-control @error('multiplier') is-invalid @enderror" placeholder="1"
                                value="{{ old('multiplier') }}">
                            @error('multiplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="filter-label">Total Kg</label>
                            <input type="number" step="0.0001" name="total_kg"
                                class="form-control @error('total_kg') is-invalid @enderror" placeholder="0.00"
                                value="{{ old('total_kg') }}">
                            @error('total_kg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-1 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-add w-100">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Form ini TIDAK membungkus tabel. Checkbox di bawah "nempel" ke form ini
             lewat atribut form="bulkDestroyForm", jadi tetap ikut ter-submit meski
             secara HTML berada di luar tag <form>. Ini supaya form delete per-baris
             (di dalam tabel) tidak perlu nested dengan form bulk delete. --}}
        <form id="bulkDestroyForm" action="{{ route('operator.product.formula.bulk-destroy') }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus semua baris formula yang dicentang?');">
            @csrf
        </form>

        <div class="mb-3 d-flex align-items-center" style="gap: .5rem;">
            <button type="submit" form="bulkDestroyForm" class="btn btn-outline-danger" id="bulkDestroyBtn" disabled>
                <i class="fas fa-trash mr-1"></i>
                Hapus Terpilih (<span id="bulkDestroyCount">0</span>)
            </button>
        </div>

        @forelse ($formulas as $multiplier => $rows)
            <div class="card card-accent mb-4">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-flask mr-2"></i>
                        Formula {{ $multiplier }}
                    </h4>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide">
                            <thead>
                                <tr>
                                    <th width="40" class="text-center">
                                        <input type="checkbox" class="select-all-in-table">
                                    </th>
                                    <th>Bahan Baku</th>
                                    <th width="150" class="text-right">Total Kg</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $row)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="ids[]" value="{{ $row->id }}"
                                                form="bulkDestroyForm" class="row-checkbox">
                                        </td>
                                        <td>{{ $row->bahanBaku->name }}</td>
                                        <td class="text-right">
                                            {{ number_format($row->total_kg, 3, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <form action="{{ route('operator.product.formula.destroy', $row->id) }}"
                                                    method="POST" style="display: inline;"
                                                    onsubmit="return confirm('Yakin ingin menghapus baris formula ini?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="fas fa-flask d-block"></i>
                        <div>
                            Belum ada formula untuk produk ini. Tambah manual di atas, atau import dari Excel.
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Pilih Produk',
                width: '100%'
            });

            const $bulkBtn = $('#bulkDestroyBtn');
            const $bulkCount = $('#bulkDestroyCount');

            function updateBulkState() {
                const checked = $('.row-checkbox:checked').length;
                $bulkCount.text(checked);
                $bulkBtn.prop('disabled', checked === 0);
            }

            $(document).on('change', '.row-checkbox', updateBulkState);

            $(document).on('change', '.select-all-in-table', function() {
                const $table = $(this).closest('table');
                $table.find('.row-checkbox').prop('checked', $(this).is(':checked'));
                updateBulkState();
            });

            updateBulkState();
        });
    </script>
@endpush
