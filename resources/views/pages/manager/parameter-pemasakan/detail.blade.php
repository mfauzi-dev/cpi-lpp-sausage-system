@extends('layouts.master')

@section('title', 'Detail Parameter Pemasakan')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Parameter Pemasakan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('manager.parameter-pemasakan.index') }}">Parameter Pemasakan</a>
                </div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <div class="section-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">1</span> Informasi Produksi</h4>
                </div>
                <div class="card-body">
                    <div class="batch-highlight">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="batch-label">Production Batch</div>
                                <div class="batch-number">
                                    {{ $parameterPemasakan->productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    Produk: {{ $parameterPemasakan->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $parameterPemasakan->productionBatch?->tanggal ? \Carbon\Carbon::parse($parameterPemasakan->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Tanggal Produksi</div>
                                <div class="info-value">
                                    {{ $parameterPemasakan->productionBatch?->tanggal ? \Carbon\Carbon::parse($parameterPemasakan->productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $parameterPemasakan->productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">{{ $parameterPemasakan->productionBatch->shift ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $parameterPemasakan->productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Nama Produk</div>
                                <div class="info-value">{{ $parameterPemasakan->productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Penggunaan Mesin dan Suhu Produk</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-fire"></i></div>
                                <div>
                                    <div class="stat-label">Nama Mesin</div>
                                    <div class="stat-value">{{ $parameterPemasakan->penggunaan_mesin ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-fire"></i></div>
                                <div>
                                    <div class="stat-label">Suhu Produk Matang</div>
                                    <div class="stat-value">{{ $parameterPemasakan->suhu_produk_matang ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Parameter Proses Pemasakan</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th width="60">No</th>
                                    <th>Tahap</th>
                                    <th width="180">Suhu (°C)</th>
                                    <th width="180">RH (%)</th>
                                    <th width="180">Waktu (Menit)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tahapan = [
                                        [
                                            'label' => 'Drying 1',
                                            'suhu' => 'drying_1_suhu',
                                            'rh' => 'drying_1_rh',
                                            'waktu' => 'drying_1_waktu',
                                        ],
                                        [
                                            'label' => 'Drying 2',
                                            'suhu' => 'drying_2_suhu',
                                            'rh' => 'drying_2_rh',
                                            'waktu' => 'drying_2_waktu',
                                        ],
                                        [
                                            'label' => 'Drying 3',
                                            'suhu' => 'drying_3_suhu',
                                            'rh' => 'drying_3_rh',
                                            'waktu' => 'drying_3_waktu',
                                        ],
                                        [
                                            'label' => 'Cooking',
                                            'suhu' => 'cooking_suhu',
                                            'rh' => 'cooking_rh',
                                            'waktu' => 'cooking_waktu',
                                        ],
                                        [
                                            'label' => 'Smoke',
                                            'suhu' => 'smoke_suhu',
                                            'rh' => 'smoke_rh',
                                            'waktu' => 'smoke_waktu',
                                        ],
                                        [
                                            'label' => 'Drying 4',
                                            'suhu' => 'drying_4_suhu',
                                            'rh' => 'drying_4_rh',
                                            'waktu' => 'drying_4_waktu',
                                        ],
                                    ];
                                @endphp
                                @foreach ($tahapan as $i => $tahap)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>{{ $tahap['label'] }}</td>
                                        <td class="text-center">
                                            {{ $parameterPemasakan->{$tahap['suhu']} !== null ? number_format((float) $parameterPemasakan->{$tahap['suhu']}, 2, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $parameterPemasakan->{$tahap['rh']} !== null ? number_format((float) $parameterPemasakan->{$tahap['rh']}, 2, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $parameterPemasakan->{$tahap['waktu']} !== null ? number_format((float) $parameterPemasakan->{$tahap['waktu']}, 2, ',', '.') : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-final">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="section-info mb-2 mb-md-0">
                            <i class="fas fa-info-circle"></i>
                            Pastikan data parameter pemasakan sudah sesuai.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('manager.parameter-pemasakan.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
