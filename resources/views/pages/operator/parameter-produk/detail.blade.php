@extends('layouts.master')

@section('title', 'Detail Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.parameter-produk.index') }}">Parameter Produk</a>
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

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
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
                                    {{ $productionBatch->kode_batch ?? '-' }}
                                </div>
                                <div class="batch-product">
                                    {{ $productionBatch->product->name ?? '-' }}
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
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">
                                    {{ $productionBatch->kode_batch ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Shift</div>
                                <div class="info-value">
                                    {{ $productionBatch->shift ? 'Shift ' . $productionBatch->shift : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Product</div>
                                <div class="info-value">
                                    {{ $productionBatch->product->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-vials"></i>
                                </div>
                                <div>
                                    <div class="stat-label">Jumlah Sampling</div>
                                    <div class="stat-value">
                                        {{ $parameterProduks->count() }} sampling
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Data Sampling</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-wide mb-0">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="60" class="text-center align-middle">Sampling Ke</th>
                                    <th rowspan="2" class="align-middle">Berat / 3 Pcs (gr)</th>
                                    <th colspan="2" class="text-center">Diameter (mm)</th>
                                    <th colspan="2" class="text-center">Panjang (cm)</th>
                                    <th colspan="2" class="text-center">Berat per Pcs (gr)</th>
                                    <th colspan="2" class="text-center">Berat Kulit (gr)</th>
                                    <th colspan="2" class="text-center">Berat Adonan (gr)</th>
                                    <th rowspan="2" class="align-middle">Berat per 3 Pcs Akhir (gr)</th>
                                    <th rowspan="2" width="110" class="text-center align-middle">Aksi</th>
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
                                        $parameterProduk = null;
                                        if (isset($parameterBySampling[$i])) {
                                            $parameterProduk = $parameterBySampling[$i];
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
                                                $standarBeratKulit = number_format($standar->berat_kulit, 2, ',', '.');
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

                                        $aktualBeratPer3Pcs = '-';
                                        $aktualDiameter = '-';
                                        $aktualPanjang = '-';
                                        $aktualBeratPerPcs = '-';
                                        $aktualBeratKulit = '-';
                                        $aktualBeratAdonan = '-';
                                        $aktualBeratPer3PcsAkhir = '-';

                                        if ($parameterProduk) {
                                            if ($parameterProduk->berat_per_3pcs !== null) {
                                                $aktualBeratPer3Pcs = number_format(
                                                    $parameterProduk->berat_per_3pcs,
                                                    2,
                                                    ',',
                                                    '.',
                                                );
                                            }
                                            if ($parameterProduk->diameter !== null) {
                                                $aktualDiameter = number_format(
                                                    $parameterProduk->diameter,
                                                    2,
                                                    ',',
                                                    '.',
                                                );
                                            }
                                            if ($parameterProduk->panjang !== null) {
                                                $aktualPanjang = number_format($parameterProduk->panjang, 2, ',', '.');
                                            }
                                            if ($parameterProduk->berat_per_pcs !== null) {
                                                $aktualBeratPerPcs = number_format(
                                                    $parameterProduk->berat_per_pcs,
                                                    2,
                                                    ',',
                                                    '.',
                                                );
                                            }
                                            if ($parameterProduk->berat_kulit !== null) {
                                                $aktualBeratKulit = number_format(
                                                    $parameterProduk->berat_kulit,
                                                    2,
                                                    ',',
                                                    '.',
                                                );
                                            }
                                            if ($parameterProduk->berat_adonan !== null) {
                                                $aktualBeratAdonan = number_format(
                                                    $parameterProduk->berat_adonan,
                                                    2,
                                                    ',',
                                                    '.',
                                                );
                                            }
                                            if ($parameterProduk->berat_per_3pcs_akhir !== null) {
                                                $aktualBeratPer3PcsAkhir = number_format(
                                                    $parameterProduk->berat_per_3pcs_akhir,
                                                    2,
                                                    ',',
                                                    '.',
                                                );
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center font-weight-bold">{{ $i }}</td>
                                        <td>{{ $aktualBeratPer3Pcs }}</td>

                                        <td class="text-center text-muted">{{ $standarDiameter }}</td>
                                        <td class="text-center font-weight-bold">{{ $aktualDiameter }}</td>

                                        <td class="text-center text-muted">{{ $standarPanjang }}</td>
                                        <td class="text-center font-weight-bold">{{ $aktualPanjang }}</td>

                                        <td class="text-center text-muted">{{ $standarBeratPerPcs }}</td>
                                        <td class="text-center font-weight-bold">{{ $aktualBeratPerPcs }}</td>

                                        <td class="text-center text-muted">{{ $standarBeratKulit }}</td>
                                        <td class="text-center font-weight-bold">{{ $aktualBeratKulit }}</td>

                                        <td class="text-center text-muted">{{ $standarBeratAdonan }}</td>
                                        <td class="text-center font-weight-bold">{{ $aktualBeratAdonan }}</td>

                                        <td>{{ $aktualBeratPer3PcsAkhir }}</td>

                                        <td class="text-center">
                                            <div class="action-buttons">
                                                @if ($parameterProduk)
                                                    <form
                                                        action="{{ route('operator.parameter-produk.destroy', $parameterProduk->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus sampling ke-{{ $i }} ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-outline-danger btn-sm" disabled
                                                        title="Belum ada data">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
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
                            Pastikan data sampling sudah sesuai sebelum keluar halaman ini.
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('operator.parameter-produk.edit', $productionBatch->id) }}"
                                class="btn btn-outline-warning mr-2" title="Edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="{{ route('operator.parameter-produk.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
