@extends('layouts.master')

@section('title', 'Detail Metal Detector')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Metal Detector</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.metal-detector.index') }}">Metal Detector</a>
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
                    <h4><span class="step-badge">2</span> Data Pemeriksaan</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="60">No</th>
                                    <th>Jenis Pemeriksaan</th>
                                    <th>No Mesin</th>
                                    <th>Petugas</th>
                                    <th>Foreman</th>
                                    <th>KR</th>
                                    <th>Waktu Awal</th>
                                    <th>Waktu Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenisList as $jenis)
                                    @php
                                        $data = $dataPemeriksaan[$jenis] ?? null;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $jenis }}</td>
                                        <td>{{ $data->no_mesin ?? '-' }}</td>
                                        <td>{{ $data->petugas ?? '-' }}</td>
                                        <td>{{ $data->foreman ?? '-' }}</td>
                                        <td>{{ $data->kr ?? '-' }}</td>
                                        <td>{{ $data && $data->waktu_awal ? \Carbon\Carbon::parse($data->waktu_awal)->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ $data && $data->waktu_akhir ? \Carbon\Carbon::parse($data->waktu_akhir)->format('H:i') : '-' }}
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
                            Pastikan data pemeriksaan metal detector sudah sesuai.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('operator.metal-detector.edit', $productionBatch->id) }}"
                                class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('operator.metal-detector.destroy', $productionBatch->id) }}"
                                method="POST" style="display: inline;"
                                onsubmit="return confirm('Yakin ingin menghapus semua data metal detector batch ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('operator.metal-detector.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
