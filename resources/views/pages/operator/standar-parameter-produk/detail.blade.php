@extends('layouts.master')

@section('title', 'Detail Standar Parameter Produk')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Detail Standar Parameter Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.standar-parameter-produk.index') }}">Standar Parameter Produk</a>
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
                    <h4><span class="step-badge">1</span> Informasi Produk</h4>
                </div>
                <div class="card-body">
                    <div class="batch-highlight">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="batch-label">Produk</div>
                                <div class="batch-number">
                                    {{ $product->name ?? '-' }}
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
                                        {{ $standarParameterProduks->count() }} sampling
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
                                    <th width="60" class="text-center">Sampling Ke</th>
                                    <th>Diameter (mm)</th>
                                    <th>Panjang (cm)</th>
                                    <th>Berat per Pcs (gr)</th>
                                    <th>Berat Kulit (gr)</th>
                                    <th>Berat Adonan (gr)</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($standarParameterProduks as $standarParameterProduk)
                                    <tr>
                                        <td class="text-center font-weight-bold">
                                            {{ $standarParameterProduk->sampling_ke }}
                                        </td>
                                        <td>
                                            {{ $standarParameterProduk->diameter !== null ? number_format($standarParameterProduk->diameter, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $standarParameterProduk->panjang !== null ? number_format($standarParameterProduk->panjang, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $standarParameterProduk->berat_per_pcs !== null ? number_format($standarParameterProduk->berat_per_pcs, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $standarParameterProduk->berat_kulit !== null ? number_format($standarParameterProduk->berat_kulit, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            {{ $standarParameterProduk->berat_adonan !== null ? number_format($standarParameterProduk->berat_adonan, 2, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="{{ route('operator.standar-parameter-produk.edit', $standarParameterProduk->id) }}"
                                                    class="btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <form
                                                    action="{{ route('operator.standar-parameter-produk.destroy', $standarParameterProduk->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus sampling ke-{{ $standarParameterProduk->sampling_ke }} ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="fas fa-vials d-block"></i>
                                                <div>Belum ada data sampling.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
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
                            <a href="{{ route('operator.standar-parameter-produk.index') }}" class="btn btn-ghost">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
