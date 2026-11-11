@extends('layouts.master')

@section('title', 'Edit Production Batch')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Production Batch</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.production-batch.index') }}">Production Batch</a>
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

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('operator.production-batch.update', $productionBatch->id) }}" method="POST"
                id="form-production-batch" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">1</span> Informasi Production Batch</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" id="tanggal"
                                        class="form-control @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal', optional($productionBatch->tanggal)->format('Y-m-d')) }}"
                                        required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Hari</label>
                                    <input type="text" id="hari" class="form-control" name="hari" readonly>
                                    <small class="form-text text-muted">Hari otomatis mengikuti tanggal yang
                                        dipilih.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Produk <span class="text-danger">*</span></label>
                                    <select name="product_id"
                                        class="form-control select2 @error('product_id') is-invalid @enderror" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id', $productionBatch->product_id) == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Kode Batch <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_batch"
                                        class="form-control @error('kode_batch') is-invalid @enderror"
                                        value="{{ old('kode_batch', $productionBatch->kode_batch) }}"
                                        placeholder="Masukkan kode batch" maxlength="255" required>
                                    @error('kode_batch')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Shift</label>
                                    <select name="shift" class="form-control @error('shift') is-invalid @enderror">
                                        <option value="">Pilih Shift</option>
                                        @foreach ([1, 2, 3] as $shift)
                                            <option value="{{ $shift }}"
                                                {{ old('shift', $productionBatch->shift) == $shift ? 'selected' : '' }}>
                                                Shift {{ $shift }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shift')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Informasi Yield dan Meat</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Yield Meat</label>
                                    <input type="number" name="yield_meat"
                                        class="form-control @error('yield_meat') is-invalid @enderror"
                                        value="{{ old('yield_meat', $productionBatch->yield_meat) }}"
                                        placeholder="Masukkan yield meat" min="0" step="0.001">
                                    @error('yield_meat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="filter-label">Total Meat</label>
                                    <input type="number" name="total_meat"
                                        class="form-control @error('total_meat') is-invalid @enderror"
                                        value="{{ old('total_meat', $productionBatch->total_meat) }}"
                                        placeholder="Masukkan total meat" min="0" step="0.001">
                                    @error('total_meat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <small class="form-text text-muted">Yield Meat dan Total Meat dapat dikosongkan jika datanya belum
                            tersedia.</small>
                    </div>
                </div>

                {{-- FOTO --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">3</span> Dokumentasi Foto</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            Upload foto baru untuk mengganti yang lama, atau centang "Hapus foto ini" untuk menghapus
                            tanpa mengganti.
                        </p>

                        <div class="row">
                            @php
                                $fotoList = [
                                    'foto_kartu_rute' => 'Kartu Rute',
                                    'foto_stamp_plastik' => 'Stamp Plastik',
                                    'foto_stamp_box' => 'Stamp Box',
                                    'foto_ed_plastik' => 'ED Plastik',
                                    'foto_ed_carton_box' => 'ED Carton Box',
                                ];
                            @endphp

                            @foreach ($fotoList as $field => $label)
                                <div class="col-md-4 col-12 mb-3">
                                    <div class="form-group mb-0">
                                        <label class="filter-label">{{ $label }}</label>

                                        {{-- Preview: foto lama dari server, atau foto baru hasil pilih/jepret --}}
                                        <div class="foto-preview-wrapper mb-2" id="preview-wrapper-{{ $field }}"
                                            style="{{ $productionBatch->{$field} ? '' : 'display: none;' }}">
                                            <img id="preview-{{ $field }}"
                                                src="{{ $productionBatch->{$field} ? asset('storage/' . $productionBatch->{$field}) : '#' }}"
                                                alt="Preview {{ $label }}" class="d-block mb-2"
                                                style="max-width: 100%; max-height: 150px; object-fit: contain; border: 1px solid #e9ecef; border-radius: 4px; padding: 4px;">
                                        </div>

                                        @if ($productionBatch->{$field})
                                            <div class="custom-control custom-checkbox mb-2"
                                                id="hapus-wrapper-{{ $field }}">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="hapus_{{ $field }}" name="hapus_{{ $field }}"
                                                    value="1">
                                                <label class="custom-control-label" for="hapus_{{ $field }}">
                                                    Hapus foto ini
                                                </label>
                                            </div>
                                        @endif

                                        <input type="file" name="{{ $field }}" id="{{ $field }}"
                                            accept="image/*" capture="environment"
                                            class="form-control foto-input @error($field) is-invalid @enderror"
                                            data-preview-target="preview-{{ $field }}"
                                            data-preview-wrapper="preview-wrapper-{{ $field }}"
                                            data-hapus-wrapper="hapus-wrapper-{{ $field }}"
                                            data-hapus-checkbox="hapus_{{ $field }}">

                                        @error($field)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card card-final mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="total-card mb-2 mb-md-0">
                                <div class="stat-icon">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Production Batch</div>
                                    <div class="stat-value">{{ $productionBatch->kode_batch }}</div>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <a href="{{ route('operator.production-batch.index') }}" class="btn btn-ghost">
                                    <i class="fas fa-arrow-left mr-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-add">
                                    <i class="fas fa-save mr-1"></i> Update Production Batch
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
                placeholder: 'Pilih Produk',
                width: '100%'
            });
        });

        function updateHari() {
            const tanggal = document.getElementById('tanggal').value;
            const hariInput = document.getElementById('hari');
            const namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

            if (tanggal) {
                const date = new Date(tanggal + 'T00:00:00');
                hariInput.value = namaHari[date.getDay()];
            } else {
                hariInput.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateHari();
            document.getElementById('tanggal').addEventListener('change', updateHari);

            document.querySelectorAll('.foto-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const previewImg = document.getElementById(input.dataset.previewTarget);
                    const previewWrapper = document.getElementById(input.dataset.previewWrapper);
                    const hapusWrapper = input.dataset.hapusWrapper ?
                        document.getElementById(input.dataset.hapusWrapper) : null;
                    const hapusCheckbox = input.dataset.hapusCheckbox ?
                        document.getElementById(input.dataset.hapusCheckbox) : null;

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            previewImg.src = ev.target.result;
                            previewWrapper.style.display = 'block';
                        };
                        reader.readAsDataURL(file);

                        if (hapusCheckbox) {
                            hapusCheckbox.checked = false;
                        }
                        if (hapusWrapper) {
                            hapusWrapper.style.display = 'none';
                        }
                    } else if (hapusWrapper) {
                        hapusWrapper.style.display = 'block';
                    }
                });
            });
        });
    </script>
@endpush
