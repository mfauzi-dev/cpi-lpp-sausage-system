@extends('layouts.master')

@section('title', 'Detail Produksi Bahan Baku')

@section('content')

    <div class="page-section">

        <div class="section-header">

            <h1>Produksi Bahan Baku</h1>

            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item">

                    <a href="{{ route('manager.produksi-bahan-baku.index') }}">

                        Produksi Bahan Baku

                    </a>

                </div>

                <div class="breadcrumb-item active">

                    Detail

                </div>

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

            {{-- INFORMASI PRODUKSI --}}

            <div class="card mb-4">

                <div class="card-header">

                    <h4>

                        <span class="step-badge">1</span>

                        Informasi Produksi

                    </h4>

                </div>

                <div class="card-body">

                    {{-- Batch Highlight --}}

                    <div class="batch-highlight">

                        <div class="row align-items-center">

                            <div class="col-md-8">

                                <div class="batch-label">

                                    Production Batch

                                </div>

                                <div class="batch-number">

                                    {{ $produksi->productionBatch->kode_batch ?? '-' }}

                                </div>

                                <div class="batch-product">

                                    {{ $produksi->productionBatch->product->name ?? '-' }}

                                </div>

                            </div>

                            <div class="col-md-4 text-md-right mt-3 mt-md-0">

                                <div class="batch-label">

                                    Tanggal Produksi

                                </div>

                                <div class="batch-number batch-date">

                                    {{ $produksi->productionBatch?->tanggal ? $produksi->productionBatch->tanggal->format('d M Y') : '-' }}

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Informasi Batch --}}

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <div class="info-box">

                                <div class="info-label">

                                    Hari

                                </div>

                                <div class="info-value">

                                    {{ $produksi->productionBatch->hari ?? '-' }}

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <div class="info-box">

                                <div class="info-label">

                                    Kode Batch

                                </div>

                                <div class="info-value">

                                    {{ $produksi->productionBatch->kode_batch ?? '-' }}

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <div class="info-box">

                                <div class="info-label">

                                    Product

                                </div>

                                <div class="info-value">

                                    {{ $produksi->productionBatch->product->name ?? '-' }}

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Statistic --}}

                    <div class="row">

                        <div class="col-md-3 mb-3">

                            <div class="stat-card">

                                <div class="stat-icon">

                                    <i class="fas fa-weight-hanging"></i>

                                </div>

                                <div>

                                    <div class="stat-label">

                                        Total Bahan Baku

                                    </div>

                                    <div class="stat-value">

                                        {{ number_format($produksi->total ?? 0, 2, ',', '.') }} Kg

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-3 mb-3">

                            <div class="stat-card">

                                <div class="stat-icon">

                                    <i class="fas fa-industry"></i>

                                </div>

                                <div>

                                    <div class="stat-label">

                                        Penggunaan

                                    </div>

                                    <div class="stat-value">

                                        {{ number_format($produksi->penggunaan ?? 0, 2, ',', '.') }} Kg

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

                                    <div class="stat-label">

                                        Sisa

                                    </div>

                                    <div class="stat-value">

                                        {{ number_format($produksi->sisa ?? 0, 2, ',', '.') }} Kg

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-3 mb-3">

                            <div class="stat-card">

                                <div class="stat-icon">

                                    <i class="fas fa-boxes"></i>

                                </div>

                                <div>

                                    <div class="stat-label">

                                        Jumlah Item

                                    </div>

                                    <div class="stat-value">

                                        {{ $produksi->items->count() }} Item

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- DATA BAHAN BAKU --}}

            <div class="card mb-4">

                <div class="card-header">

                    <h4>

                        <span class="step-badge">2</span>

                        Data Bahan Baku

                    </h4>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-wide">

                            <thead>

                                <tr>

                                    <th width="60" class="text-center">

                                        No

                                    </th>

                                    <th>

                                        Bahan Baku

                                    </th>

                                    <th>

                                        Formula

                                    </th>


                                    <th>

                                        Total (Kg)

                                    </th>

                                    <th>

                                        Kode Batch

                                    </th>

                                    <th>

                                        Best Before

                                    </th>

                                    <th>

                                        Suhu RM (°C)

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($produksi->items as $index => $item)
                                    <tr>

                                        <td class="text-center font-weight-bold">

                                            {{ $index + 1 }}

                                        </td>

                                        <td>

                                            {{ $item->bahanBaku->name ?? '-' }}

                                        </td>

                                        <td>

                                            @if ($item->productFormula)
                                                <span class="badge-soft">

                                                    {{ $item->productFormula->multiplier }}

                                                </span>
                                            @else
                                                <span class="value-empty">-</span>
                                            @endif

                                        </td>


                                        <td>

                                            @if ($item->productFormula)
                                                <strong>

                                                    {{ number_format($item->productFormula->total_kg, 2, ',', '.') }}

                                                </strong>

                                                Kg
                                            @else
                                                <span class="value-empty">-</span>
                                            @endif

                                        </td>

                                        <td>

                                            @if ($item->kode_batch)
                                                <span class="badge-value">

                                                    {{ $item->kode_batch }}

                                                </span>
                                            @else
                                                <span class="value-empty">-</span>
                                            @endif

                                        </td>

                                        <td>

                                            @if ($item->best_before)
                                                {{ $item->best_before->format('d M Y') }}
                                            @else
                                                <span class="value-empty">-</span>
                                            @endif

                                        </td>

                                        <td>

                                            @if ($item->suhu_rm !== null)
                                                {{ $item->suhu_rm }} °C
                                            @else
                                                <span class="value-empty">-</span>
                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="7">

                                            <div class="empty-state">

                                                <i class="fas fa-box-open d-block"></i>

                                                <div>

                                                    Belum ada data bahan baku.

                                                </div>

                                            </div>

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                            @if ($produksi->items->count() > 0)
                                <tfoot>

                                    <tr>

                                        <td colspan="6" class="text-right font-weight-bold">

                                            Total Bahan Baku

                                        </td>

                                        <td class="font-weight-bold">

                                            {{ number_format($produksi->total ?? 0, 2, ',', '.') }}

                                            Kg

                                        </td>

                                    </tr>

                                </tfoot>
                            @endif

                        </table>

                    </div>

                </div>

            </div>

            {{-- ACTION --}}

            <div class="card card-final">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>

                            <div class="info-label mb-1">

                                Penggunaan / Sisa

                            </div>

                            <div class="stat-value">

                                {{ number_format($produksi->penggunaan ?? 0, 2, ',', '.') }} /
                                {{ number_format($produksi->sisa ?? 0, 2, ',', '.') }} Kg

                            </div>

                        </div>

                        <div class="mt-3 mt-md-0">

                            <a href="{{ route('manager.produksi-bahan-baku.index') }}" class="btn btn-ghost mr-1">

                                <i class="fas fa-arrow-left mr-1"></i>

                                Kembali

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
