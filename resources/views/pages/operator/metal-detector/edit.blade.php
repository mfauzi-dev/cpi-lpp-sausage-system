@extends('layouts.master')

@section('title', 'Edit Metal Detector')

@section('content')
    @php
        $jenisList = ['Metal Detector', 'Fe / Sus / Non Fe', 'Timbangan'];
    @endphp

    <div class="page-section">
        <div class="section-header">
            <h1>Edit Metal Detector</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.metal-detector.index') }}">Metal Detector</a>
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

            <form action="{{ route('operator.metal-detector.update', $productionBatch->id) }}" method="POST"
                id="metalDetectorForm">
                @csrf
                @method('PUT')

                {{-- STEP 1 --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">1</span> Informasi Produksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Tanggal Produksi</div>
                                    <div class="info-value">
                                        {{ $productionBatch?->tanggal ? \Carbon\Carbon::parse($productionBatch->tanggal)->format('d-m-Y') : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Product</div>
                                    <div class="info-value">{{ $productionBatch?->product?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value">{{ $productionBatch?->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value">{{ $productionBatch?->shift ?? '-' }}</div>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide" id="tablePemeriksaan">
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
                                    @foreach ($jenisList as $i => $jenis)
                                        @php
                                            $data = $dataPemeriksaan[$jenis] ?? null;
                                            $waktuAwal =
                                                $data && $data->waktu_awal
                                                    ? \Carbon\Carbon::parse($data->waktu_awal)->format('H:i')
                                                    : '';
                                            $waktuAkhir =
                                                $data && $data->waktu_akhir
                                                    ? \Carbon\Carbon::parse($data->waktu_akhir)->format('H:i')
                                                    : '';
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $jenis }}
                                                <input type="hidden"
                                                    name="pemeriksaan[{{ $i }}][jenis_pemeriksaan]"
                                                    value="{{ $jenis }}">
                                            </td>
                                            <td>
                                                <input type="text" name="pemeriksaan[{{ $i }}][no_mesin]"
                                                    class="form-control"
                                                    value="{{ old("pemeriksaan.$i.no_mesin", $data->no_mesin ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text" name="pemeriksaan[{{ $i }}][petugas]"
                                                    class="form-control"
                                                    value="{{ old("pemeriksaan.$i.petugas", $data->petugas ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text" name="pemeriksaan[{{ $i }}][foreman]"
                                                    class="form-control"
                                                    value="{{ old("pemeriksaan.$i.foreman", $data->foreman ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text" name="pemeriksaan[{{ $i }}][kr]"
                                                    class="form-control"
                                                    value="{{ old("pemeriksaan.$i.kr", $data->kr ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="time" name="pemeriksaan[{{ $i }}][waktu_awal]"
                                                    class="form-control"
                                                    value="{{ old("pemeriksaan.$i.waktu_awal", $waktuAwal) }}">
                                            </td>
                                            <td>
                                                <input type="time" name="pemeriksaan[{{ $i }}][waktu_akhir]"
                                                    class="form-control"
                                                    value="{{ old("pemeriksaan.$i.waktu_akhir", $waktuAkhir) }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.metal-detector.index') }}" class="btn btn-ghost mb-2">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-save mr-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
