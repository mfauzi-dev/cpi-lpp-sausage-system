@extends('layouts.master')

@section('title', 'Edit Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.parameter-produk.index') }}">Parameter Produk</a>
                </div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-lead">
            Perbarui data sampling untuk production batch ini. Sampling yang dikosongkan akan dihapus.
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

            <form action="{{ route('operator.parameter-produk.update', $productionBatch->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">1</span> Informasi Produksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Tanggal Produksi</div>
                                    <div class="info-value">
                                        {{ $productionBatch->tanggal ? \Carbon\Carbon::parse($productionBatch->tanggal)->format('d M Y') : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value">{{ $productionBatch->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value">
                                        {{ $productionBatch->shift ? 'Shift ' . $productionBatch->shift : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-box">
                                    <div class="info-label">Product</div>
                                    <div class="info-value">{{ $productionBatch->product->name ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent mb-4">
                    <div class="card-header">
                        <h4><span class="step-badge">2</span> Data Parameter Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide" id="tableSampling">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center align-middle" width="60">No</th>
                                        <th rowspan="2" class="align-middle">Sampling Ke</th>
                                        <th rowspan="2" class="align-middle">Berat per 3 Pcs (gr)</th>
                                        <th colspan="2" class="text-center">Diameter (mm)</th>
                                        <th colspan="2" class="text-center">Panjang (cm)</th>
                                        <th colspan="2" class="text-center">Berat per Pcs (gr)</th>
                                        <th colspan="2" class="text-center">Berat Kulit (gr)</th>
                                        <th colspan="2" class="text-center">Berat Adonan (gr)</th>
                                        <th rowspan="2" class="align-middle">Berat per 3 Pcs Akhir (gr)</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                        <th class="text-center">Standar</th>
                                        <th class="text-center">Aktual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $param = null;
                                            if (isset($parameterBySampling[$i])) {
                                                $param = $parameterBySampling[$i];
                                            }

                                            $standar = null;
                                            if (isset($standarBySampling[$i])) {
                                                $standar = $standarBySampling[$i];
                                            }

                                            $standarDiameter = '-';
                                            $standarPanjang = '-';
                                            $standarBeratPerPcs = '-';
                                            $standarBeratKulit = '-';
                                            $standarBeratAdonan = '-';

                                            if ($standar) {
                                                if ($standar->diameter !== null) {
                                                    $standarDiameter = number_format($standar->diameter, 2, ',', '.');
                                                }
                                                if ($standar->panjang !== null) {
                                                    $standarPanjang = number_format($standar->panjang, 2, ',', '.');
                                                }
                                                if ($standar->berat_per_pcs !== null) {
                                                    $standarBeratPerPcs = number_format(
                                                        $standar->berat_per_pcs,
                                                        2,
                                                        ',',
                                                        '.',
                                                    );
                                                }
                                                if ($standar->berat_kulit !== null) {
                                                    $standarBeratKulit = number_format(
                                                        $standar->berat_kulit,
                                                        2,
                                                        ',',
                                                        '.',
                                                    );
                                                }
                                                if ($standar->berat_adonan !== null) {
                                                    $standarBeratAdonan = number_format(
                                                        $standar->berat_adonan,
                                                        2,
                                                        ',',
                                                        '.',
                                                    );
                                                }
                                            }

                                            $valBeratPer3Pcs = '';
                                            $valDiameter = '';
                                            $valPanjang = '';
                                            $valBeratPerPcs = '';
                                            $valBeratKulit = '';
                                            $valBeratAdonan = '';
                                            $valBeratPer3PcsAkhir = '';

                                            if ($param) {
                                                if ($param->berat_per_3pcs !== null) {
                                                    $valBeratPer3Pcs = $param->berat_per_3pcs;
                                                }
                                                if ($param->diameter !== null) {
                                                    $valDiameter = $param->diameter;
                                                }
                                                if ($param->panjang !== null) {
                                                    $valPanjang = $param->panjang;
                                                }
                                                if ($param->berat_per_pcs !== null) {
                                                    $valBeratPerPcs = $param->berat_per_pcs;
                                                }
                                                if ($param->berat_kulit !== null) {
                                                    $valBeratKulit = $param->berat_kulit;
                                                }
                                                if ($param->berat_adonan !== null) {
                                                    $valBeratAdonan = $param->berat_adonan;
                                                }
                                                if ($param->berat_per_3pcs_akhir !== null) {
                                                    $valBeratPer3PcsAkhir = $param->berat_per_3pcs_akhir;
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][sampling_ke]"
                                                    class="form-control" value="{{ $i }}" min="1"
                                                    max="5" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_per_3pcs]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_per_3pcs", $valBeratPer3Pcs) }}">
                                            </td>

                                            <td class="text-center text-muted align-middle">{{ $standarDiameter }}</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][diameter]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.diameter", $valDiameter) }}">
                                            </td>

                                            <td class="text-center text-muted align-middle">{{ $standarPanjang }}</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][panjang]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.panjang", $valPanjang) }}">
                                            </td>

                                            <td class="text-center text-muted align-middle">{{ $standarBeratPerPcs }}</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_per_pcs]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_per_pcs", $valBeratPerPcs) }}">
                                            </td>

                                            <td class="text-center text-muted align-middle">{{ $standarBeratKulit }}</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_kulit]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_kulit", $valBeratKulit) }}">
                                            </td>

                                            <td class="text-center text-muted align-middle">{{ $standarBeratAdonan }}</td>
                                            <td>
                                                <input type="number" name="sampling[{{ $i }}][berat_adonan]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_adonan", $valBeratAdonan) }}">
                                            </td>

                                            <td>
                                                <input type="number"
                                                    name="sampling[{{ $i }}][berat_per_3pcs_akhir]"
                                                    class="form-control" step="0.01" min="0"
                                                    value="{{ old("sampling.$i.berat_per_3pcs_akhir", $valBeratPer3PcsAkhir) }}">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.parameter-produk.detail', $productionBatch->id) }}"
                        class="btn btn-ghost mb-2">
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
