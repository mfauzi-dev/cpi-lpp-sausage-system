@extends('layouts.master')

@section('title', 'Detail Standar Mesin Packing Dalam')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Standar Mesin Packing Dalam</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('manager.standar-mesin-packing-dalam.index') }}">Standar Mesin Packing Dalam</a>
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

            {{-- STEP 1 --}}
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
                                    {{ $productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    Produk: {{ $productionBatch->product?->name ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $productionBatch->tanggal ? \Carbon\Carbon::parse($productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Tanggal Produksi</div>
                                <div class="info-value">
                                    {{ $productionBatch->tanggal ? \Carbon\Carbon::parse($productionBatch->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Hari</div>
                                <div class="info-value">{{ $productionBatch->hari ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">{{ $productionBatch->shift ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-label">Nama Produk</div>
                                <div class="info-value">{{ $productionBatch->product?->name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div class="card card-accent mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Data Standar Mesin</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="60">No</th>
                                    <th>Parameter Mesin</th>
                                    <th>Sausage Cutter</th>
                                    <th>Vacuum Pack</th>
                                    <th>Thermoforming</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parameterList as $parameter)
                                    @php
                                        $data = $dataStandar[$parameter] ?? null;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $parameter }}</td>
                                        <td>{{ $data->penggunaan_mesin_sausage_cutter ?? '-' }}</td>
                                        <td>{{ $data->penggunaan_mesin_vacuum_pack ?? '-' }}</td>
                                        <td>{{ $data->penggunaan_mesin_thermoforming ?? '-' }}</td>
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
                            Data standar mesin packing dalam untuk batch ini.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('manager.standar-mesin-packing-dalam.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
