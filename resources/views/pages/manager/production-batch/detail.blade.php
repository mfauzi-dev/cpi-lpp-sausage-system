@extends('layouts.master')

@section('title', 'Detail Production Batch')

@push('addon-style')
    <style>
        .pb-page {
            --pb-primary: #1B4B43;
            --pb-primary-light: #E8F0EE;
            --pb-accent: #D98C3D;
            --pb-border: #E3E7E1;
            --pb-text: #1F2A24;
            --pb-muted: #5B6A62;
            --pb-soft: #F7F9F7;
        }

        .pb-page .section-header h1 {
            font-weight: 700;
            letter-spacing: -0.01em;
            color: var(--pb-text);
        }

        .pb-page .card {
            border: none;
            border-left: 4px solid var(--pb-primary);
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(15, 30, 25, 0.06), 0 1px 2px rgba(15, 30, 25, 0.04);
            overflow: hidden;
        }

        .pb-page .card-header {
            background: #fff;
            border-bottom: 1px solid var(--pb-border);
            padding: 1rem 1.5rem;
        }

        .pb-page .card-header h4 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--pb-text);
            display: flex;
            align-items: center;
        }

        .pb-page .card-header h4 i {
            color: var(--pb-primary);
        }

        .pb-page .card-body {
            padding: 1.5rem;
        }

        .pb-page .step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 26px;
            height: 26px;
            padding: 0 4px;
            border-radius: 50%;
            background: var(--pb-primary);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .pb-page .batch-highlight {
            background: linear-gradient(135deg, var(--pb-primary), #28665A);
            color: #fff;
            border-radius: 9px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.25rem;
        }

        .pb-page .batch-highlight .batch-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            opacity: 0.75;
            font-weight: 600;
        }

        .pb-page .batch-highlight .batch-number {
            font-size: 1.45rem;
            font-weight: 700;
            margin-top: 0.2rem;
        }

        .pb-page .batch-highlight .batch-product {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 0.15rem;
        }

        .pb-page .info-box {
            height: 100%;
            background: var(--pb-soft);
            border: 1px solid var(--pb-border);
            border-radius: 8px;
            padding: 1rem 1.1rem;
        }

        .pb-page .info-label {
            color: var(--pb-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.35rem;
        }

        .pb-page .info-value {
            color: var(--pb-text);
            font-size: 0.95rem;
            font-weight: 600;
            min-height: 22px;
            overflow-wrap: anywhere;
        }

        .pb-page .stat-card {
            height: 100%;
            background: #fff;
            border: 1px solid var(--pb-border);
            border-radius: 9px;
            padding: 1rem;
            display: flex;
            align-items: center;
        }

        .pb-page .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--pb-primary-light);
            color: var(--pb-primary);
            font-size: 1.05rem;
            margin-right: 0.85rem;
            flex-shrink: 0;
        }

        .pb-page .stat-label {
            color: var(--pb-muted);
            font-size: 0.73rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .pb-page .stat-value {
            color: var(--pb-text);
            font-size: 1rem;
            font-weight: 700;
            margin-top: 0.15rem;
            overflow-wrap: anywhere;
        }

        .pb-page .process-card {
            height: 100%;
            background: #fff;
            border: 1px solid var(--pb-border);
            border-radius: 9px;
            padding: 1rem 1.1rem;
        }

        .pb-page .process-label {
            color: var(--pb-muted);
            font-size: 0.73rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 0.3rem;
        }

        .pb-page .process-value {
            color: var(--pb-text);
            font-size: 0.95rem;
            font-weight: 700;
            min-height: 20px;
            overflow-wrap: anywhere;
        }

        .pb-page .process-empty {
            text-align: center;
            padding: 1.5rem 1rem;
            background: var(--pb-soft);
            border: 1px dashed var(--pb-border);
            border-radius: 8px;
            color: var(--pb-muted);
        }

        .pb-page .process-empty i {
            font-size: 1.4rem;
            opacity: .5;
            margin-bottom: .4rem;
        }

        .pb-page .entry-divider:not(:last-child) {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed var(--pb-border);
        }

        .pb-page .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .pb-page .table {
            margin-bottom: 0;
        }

        .pb-page .table thead th {
            background: var(--pb-primary-light);
            color: var(--pb-primary);
            font-weight: 600;
            font-size: 0.78rem;
            border-bottom: none;
            vertical-align: middle;
            white-space: nowrap;
            padding: 0.8rem 0.9rem;
        }

        .pb-page .table td,
        .pb-page .table tbody th {
            vertical-align: middle;
            font-size: 0.85rem;
            color: var(--pb-text);
            padding: 0.8rem 0.9rem;
            white-space: nowrap;
        }

        .pb-page .table-bordered td,
        .pb-page .table-bordered th {
            border-color: var(--pb-border);
        }

        .pb-page .table tbody tr:hover {
            background: #FAFBF9;
        }

        .pb-page .badge-soft {
            display: inline-block;
            background: var(--pb-primary-light);
            color: var(--pb-primary);
            border-radius: 20px;
            padding: 0.3rem 0.65rem;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .pb-page .btn-ghost {
            color: var(--pb-muted);
            background: transparent;
            border: 1px solid var(--pb-border);
        }

        .pb-page .btn-ghost:hover {
            background: #F3F5F3;
            color: var(--pb-text);
        }

        .pb-page .btn-excel {
            color: #1B4B43;
            background: var(--pb-primary-light);
            border: 1px solid #C9DCD7;
        }

        .pb-page .btn-excel:hover {
            background: #DCEAE6;
            color: #153B35;
        }

        @media (max-width: 767.98px) {
            .pb-page .card-body {
                padding: 1rem;
            }

            .pb-page .card-header {
                padding: 0.9rem 1rem;
            }

            .pb-page .batch-highlight {
                padding: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="pb-page">
        <div class="section-header">
            <h1>Production Batch</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('manager.production-batch.index') }}">Production Batch</a>
                </div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <div class="section-body">

            {{-- 1. INFORMASI PRODUCTION BATCH --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">1</span> Informasi Production Batch</h4>
                </div>
                <div class="card-body">
                    <div class="batch-highlight">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="batch-label">Kode Batch</div>
                                <div class="batch-number">{{ $productionBatch->kode_batch ?? '-' }}</div>
                                <div class="batch-product">
                                    {{ $productionBatch->product->name ?? '-' }} &middot;
                                    Shift {{ $productionBatch->shift ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <div class="batch-label">Tanggal Produksi</div>
                                <div class="batch-number" style="font-size: 1.1rem;">
                                    {{ $productionBatch->tanggal ? $productionBatch->tanggal->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Product</div>
                                <div class="info-value">{{ $productionBatch->product->name ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Kode Batch</div>
                                <div class="info-value">{{ $productionBatch->kode_batch ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Total Meat (Kg)</div>
                                <div class="info-value">
                                    {{ $productionBatch->total_meat !== null ? number_format((float) $productionBatch->total_meat, 3, ',', '.') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Yield Meat (%)</div>
                                <div class="info-value">
                                    {{ $productionBatch->yield_meat !== null ? number_format((float) $productionBatch->yield_meat, 3, ',', '.') . '%' : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. PRODUKSI BAHAN BAKU (tambah baris -> table) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">2</span> Produksi Bahan Baku</h4>
                </div>
                <div class="card-body">
                    @forelse ($productionBatch->produksiBahanBaku as $produksi)
                        <div class="entry-divider">
                            <div class="batch-highlight">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="batch-label">Total (Kg)</div>
                                        <div class="batch-number">
                                            {{ number_format((float) $produksi->total, 2, ',', '.') }}</div>
                                    </div>
                                    <div class="col-md-4 mt-3 mt-md-0">
                                        <div class="batch-label">Penggunaan (Kg)</div>
                                        <div class="batch-number">
                                            {{ number_format((float) $produksi->penggunaan, 2, ',', '.') }}</div>
                                    </div>
                                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                        <div class="batch-label">Sisa (Kg)</div>
                                        <div class="batch-number">{{ number_format((float) $produksi->sisa, 2, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($produksi->items->count())
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Bahan Baku</th>
                                                <th>Formula</th>
                                                <th>Kode Batch</th>
                                                <th>Best Before</th>
                                                <th class="text-right">Total (Kg)</th>
                                                <th class="text-right">Suhu RM (&deg;C)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($produksi->items as $item)
                                                <tr>
                                                    <td>{{ $item->bahanBaku->name ?? '-' }}</td>
                                                    <td>{{ $item->productFormula ? 'Formula ' . $item->productFormula->multiplier : '-' }}
                                                    </td>
                                                    <td>{{ $item->kode_batch ?? '-' }}</td>
                                                    <td>{{ $item->best_before ? $item->best_before->format('d M Y') : '-' }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format((float) $item->total_kg, 2, ',', '.') }}</td>
                                                    <td class="text-right">
                                                        {{ $item->suhu_rm !== null ? number_format((float) $item->suhu_rm, 1, ',', '.') : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="process-empty"><i class="fas fa-box d-block"></i>Belum ada item bahan baku.
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-shopping-basket d-block"></i>
                            Belum ada data Produksi Bahan Baku untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 3. PENGGUNAAN MESIN (single-submit -> card) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">3</span> Penggunaan Mesin</h4>
                </div>
                <div class="card-body">
                    @forelse ($productionBatch->pengguaanMesins as $mesin)
                        <div class="entry-divider">
                            <div class="mb-3"><span class="badge-soft">{{ $mesin->name ?? '-' }}</span></div>
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-tachometer-alt"></i></div>
                                        <div>
                                            <div class="stat-label">Speed Machine</div>
                                            <div class="stat-value">
                                                {{ $mesin->speed_machine !== null ? number_format((float) $mesin->speed_machine, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Holeplate / Knife</div>
                                            <div class="stat-value">{{ $mesin->ukuran_holeplate_knife ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-link"></i></div>
                                        <div>
                                            <div class="stat-label">Linker</div>
                                            <div class="stat-value">{{ $mesin->linker ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-flask"></i></div>
                                        <div>
                                            <div class="stat-label">Stuffing Tube</div>
                                            <div class="stat-value">{{ $mesin->stuffing_tube ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-sync-alt"></i></div>
                                        <div>
                                            <div class="stat-label">Twisting</div>
                                            <div class="stat-value">{{ $mesin->twisting ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-cog"></i></div>
                                        <div>
                                            <div class="stat-label">Chuck</div>
                                            <div class="stat-value">{{ $mesin->chuck ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Mulai</div>
                                            <div class="stat-value">
                                                {{ $mesin->waktu_mulai ? substr($mesin->waktu_mulai, 0, 5) : '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Selesai</div>
                                            <div class="stat-value">
                                                {{ $mesin->waktu_selesai ? substr($mesin->waktu_selesai, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-wrench"></i></div>
                                        <div>
                                            <div class="stat-label">Downtime / Kerusakan</div>
                                            <div class="stat-value">{{ $mesin->downtime_kerusakan ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                                        <div>
                                            <div class="stat-label">Downtime (Menit)</div>
                                            <div class="stat-value text-alert">
                                                {{ $mesin->downtime_lama_waktu !== null ? number_format((float) $mesin->downtime_lama_waktu, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-cogs d-block"></i>
                            Belum ada data Penggunaan Mesin untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 4. PARAMETER PRODUK (sampling -> table) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">4</span> Parameter Produk</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->parameterProduks->count())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sampling Ke</th>
                                        <th class="text-right">Berat / 3 Pcs (gr)</th>
                                        <th class="text-right">Diameter (mm)</th>
                                        <th class="text-right">Panjang (cm)</th>
                                        <th class="text-right">Berat / Pcs (gr)</th>
                                        <th class="text-right">Berat Kulit (gr)</th>
                                        <th class="text-right">Berat Adonan (gr)</th>
                                        <th class="text-right">Berat / 3 Pcs Akhir (gr)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productionBatch->parameterProduks->sortBy('sampling_ke') as $pp)
                                        <tr>
                                            <td class="text-center">{{ $pp->sampling_ke ?? '-' }}</td>
                                            <td class="text-right">
                                                {{ $pp->berat_per_3pcs !== null ? number_format((float) $pp->berat_per_3pcs, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $pp->diameter !== null ? number_format((float) $pp->diameter, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $pp->panjang !== null ? number_format((float) $pp->panjang, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $pp->berat_per_pcs !== null ? number_format((float) $pp->berat_per_pcs, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $pp->berat_kulit !== null ? number_format((float) $pp->berat_kulit, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $pp->berat_adonan !== null ? number_format((float) $pp->berat_adonan, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $pp->berat_per_3pcs_akhir !== null ? number_format((float) $pp->berat_per_3pcs_akhir, 2, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-ruler-combined d-block"></i>
                            Belum ada data Parameter Produk untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 5. STANDAR PARAMETER PRODUK (sampling -> table) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">5</span> Standar Parameter Produk</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->standarParameterProduks->count())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sampling Ke</th>
                                        <th class="text-right">Diameter (mm)</th>
                                        <th class="text-right">Panjang (cm)</th>
                                        <th class="text-right">Berat / Pcs (gr)</th>
                                        <th class="text-right">Berat Kulit (gr)</th>
                                        <th class="text-right">Berat Adonan (gr)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productionBatch->standarParameterProduks->sortBy('sampling_ke') as $spp)
                                        <tr>
                                            <td class="text-center">{{ $spp->sampling_ke ?? '-' }}</td>
                                            <td class="text-right">
                                                {{ $spp->diameter !== null ? number_format((float) $spp->diameter, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spp->panjang !== null ? number_format((float) $spp->panjang, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spp->berat_per_pcs !== null ? number_format((float) $spp->berat_per_pcs, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spp->berat_kulit !== null ? number_format((float) $spp->berat_kulit, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spp->berat_adonan !== null ? number_format((float) $spp->berat_adonan, 2, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-clipboard-check d-block"></i>
                            Belum ada data Standar Parameter Produk untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 6. SUHU AREA (fixed category table per entry) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">6</span> Suhu Area</h4>
                </div>
                <div class="card-body">
                    @php
                        $suhuKategori = [
                            'Chillroom' => ['chillroom_std', 'chillroom_act'],
                            'Meatprep' => ['meatprep_std', 'meatprep_act'],
                            'Cooking' => ['cooking_std', 'cooking_act'],
                            'Seasoning' => ['seasoning_std', 'seasoning_act'],
                            'Cooling Down' => ['cooling_down_std', 'cooling_down_act'],
                            'Packing Dalam' => ['packing_dalam_std', 'packing_dalam_act'],
                            'Packing Luar' => ['packing_luar_std', 'packing_luar_act'],
                        ];
                    @endphp

                    @forelse ($productionBatch->suhuAreas as $suhu)
                        <div class="entry-divider">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Suhu Area</th>
                                            <th>Std (&deg;C)</th>
                                            <th>Act (&deg;C)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suhuKategori as $label => $fields)
                                            <tr>
                                                <th>{{ $label }}</th>
                                                <td class="text-right">
                                                    {{ $suhu->{$fields[0]} !== null ? number_format((float) $suhu->{$fields[0]}, 2, ',', '.') : '-' }}
                                                </td>
                                                <td class="text-right">
                                                    {{ $suhu->{$fields[1]} !== null ? number_format((float) $suhu->{$fields[1]}, 2, ',', '.') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-thermometer-half d-block"></i>
                            Belum ada data Suhu Area untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 7. PARAMETER PEMASAKAN (fixed stage table per entry) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">7</span> Parameter Pemasakan</h4>
                </div>
                <div class="card-body">
                    @php
                        $tahapanPemasakan = [
                            'Drying 1' => ['drying_1_suhu', 'drying_1_rh', 'drying_1_waktu'],
                            'Drying 2' => ['drying_2_suhu', 'drying_2_rh', 'drying_2_waktu'],
                            'Drying 3' => ['drying_3_suhu', 'drying_3_rh', 'drying_3_waktu'],
                            'Cooking' => ['cooking_suhu', 'cooking_rh', 'cooking_waktu'],
                            'Smoke' => ['smoke_suhu', 'smoke_rh', 'smoke_waktu'],
                            'Drying 4' => ['drying_4_suhu', 'drying_4_rh', 'drying_4_waktu'],
                        ];
                    @endphp

                    @forelse ($productionBatch->parameterPemasakans as $pm)
                        <div class="entry-divider">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <div class="info-box">
                                        <div class="info-label">Nama Mesin</div>
                                        <div class="info-value">{{ $pm->penggunaan_mesin ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-box">
                                        <div class="info-label">Suhu Produk Matang (&deg;C)</div>
                                        <div class="info-value">
                                            {{ $pm->suhu_produk_matang !== null ? number_format((float) $pm->suhu_produk_matang, 2, ',', '.') : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Tahap</th>
                                            <th>Suhu (&deg;C)</th>
                                            <th>RH (%)</th>
                                            <th>Waktu (Menit)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahapanPemasakan as $label => $fields)
                                            <tr>
                                                <th>{{ $label }}</th>
                                                <td class="text-right">
                                                    {{ $pm->{$fields[0]} !== null ? number_format((float) $pm->{$fields[0]}, 2, ',', '.') : '-' }}
                                                </td>
                                                <td class="text-right">
                                                    {{ $pm->{$fields[1]} !== null ? number_format((float) $pm->{$fields[1]}, 2, ',', '.') : '-' }}
                                                </td>
                                                <td class="text-right">
                                                    {{ $pm->{$fields[2]} !== null ? number_format((float) $pm->{$fields[2]}, 2, ',', '.') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-fire d-block"></i>
                            Belum ada data Parameter Pemasakan untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 8. MONITORING PEMASAKAN (single-submit -> card) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">8</span> Monitoring Pemasakan</h4>
                </div>
                <div class="card-body">
                    @forelse ($productionBatch->monitoringPemasakans as $mp)
                        <div class="entry-divider">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Mulai</div>
                                            <div class="stat-value">
                                                {{ $mp->waktu_pemasakan_mulai ? substr($mp->waktu_pemasakan_mulai, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Selesai</div>
                                            <div class="stat-value">
                                                {{ $mp->waktu_pemasakan_selesai ? substr($mp->waktu_pemasakan_selesai, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-dolly"></i></div>
                                        <div>
                                            <div class="stat-label">Jumlah Trolly (Pcs)</div>
                                            <div class="stat-value">
                                                {{ $mp->jumlah_trolly_pcs !== null ? number_format((float) $mp->jumlah_trolly_pcs, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                                        <div>
                                            <div class="stat-label">Cooling Down (Menit)</div>
                                            <div class="stat-value">
                                                {{ $mp->cooling_down_waktu !== null ? number_format((float) $mp->cooling_down_waktu, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-thermometer-half"></i></div>
                                        <div>
                                            <div class="stat-label">Suhu Ruang (&deg;C)</div>
                                            <div class="stat-value">
                                                {{ $mp->cooling_down_suhu_ruang !== null ? number_format((float) $mp->cooling_down_suhu_ruang, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-thermometer-half"></i></div>
                                        <div>
                                            <div class="stat-label">Suhu Produk (&deg;C)</div>
                                            <div class="stat-value">
                                                {{ $mp->cooling_down_suhu_produk !== null ? number_format((float) $mp->cooling_down_suhu_produk, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-wind"></i></div>
                                        <div>
                                            <div class="stat-label">Pressure Angin</div>
                                            <div class="stat-value">
                                                {{ $mp->pressure_angin !== null ? number_format((float) $mp->pressure_angin, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-tachometer-alt"></i></div>
                                        <div>
                                            <div class="stat-label">Tekanan Steam Header</div>
                                            <div class="stat-value">
                                                {{ $mp->tekanan_steam_header !== null ? number_format((float) $mp->tekanan_steam_header, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-industry"></i></div>
                                        <div>
                                            <div class="stat-label">Smoke Generator</div>
                                            <div class="stat-value">
                                                {{ $mp->smoke_generator !== null ? number_format((float) $mp->smoke_generator, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-wrench"></i></div>
                                        <div>
                                            <div class="stat-label">Downtime / Kerusakan</div>
                                            <div class="stat-value">{{ $mp->downtime_kerusakan ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Downtime (Menit)</div>
                                            <div class="stat-value text-alert">
                                                {{ $mp->downtime_waktu !== null ? number_format((float) $mp->downtime_waktu, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-tachometer-alt d-block"></i>
                            Belum ada data Monitoring Pemasakan untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 9. MONITORING LINE BASO (single-submit -> card) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">9</span> Monitoring Line Baso</h4>
                </div>
                <div class="card-body">
                    @forelse ($productionBatch->monitoringLineBasos as $mlb)
                        <div class="entry-divider">
                            <div class="mb-3"><span class="badge-soft">{{ $mlb->line_baso ?? '-' }}</span></div>
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-tint"></i></div>
                                        <div>
                                            <div class="stat-label">Suhu Air (&deg;C)</div>
                                            <div class="stat-value">
                                                {{ $mlb->parameter_pemasakan_suhu_air !== null ? number_format((float) $mlb->parameter_pemasakan_suhu_air, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-thermometer-half"></i></div>
                                        <div>
                                            <div class="stat-label">Suhu Produk (&deg;C)</div>
                                            <div class="stat-value">
                                                {{ $mlb->parameter_pemasakan_suhu_produk !== null ? number_format((float) $mlb->parameter_pemasakan_suhu_produk, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-check-square"></i></div>
                                        <div>
                                            <div class="stat-label">Bentuk</div>
                                            <div
                                                class="stat-value {{ $mlb->parameter_pemasakan_bentuk == 'Tidak OK' ? 'text-alert' : '' }}">
                                                {{ $mlb->parameter_pemasakan_bentuk ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-fire"></i></div>
                                        <div>
                                            <div class="stat-label">Suhu Produk Matang (&deg;C)</div>
                                            <div class="stat-value">
                                                {{ $mlb->suhu_produk_matang !== null ? number_format((float) $mlb->suhu_produk_matang, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Forming Mulai</div>
                                            <div class="stat-value">
                                                {{ $mlb->waktu_forming_mulai ? substr($mlb->waktu_forming_mulai, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Forming Selesai</div>
                                            <div class="stat-value">
                                                {{ $mlb->waktu_forming_selesai ? substr($mlb->waktu_forming_selesai, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-snowflake"></i></div>
                                        <div>
                                            <div class="stat-label">Cooling Down Mulai</div>
                                            <div class="stat-value">
                                                {{ $mlb->cooling_down_mulai ? substr($mlb->cooling_down_mulai, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-snowflake"></i></div>
                                        <div>
                                            <div class="stat-label">Cooling Down Selesai</div>
                                            <div class="stat-value">
                                                {{ $mlb->cooling_down_selesai ? substr($mlb->cooling_down_selesai, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-sitemap d-block"></i>
                            Belum ada data Monitoring Line Baso untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 10. REJECT (fixed category table per entry) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">10</span> Reject</h4>
                </div>
                <div class="card-body">
                    @forelse ($productionBatch->rejects as $reject)
                        <div class="entry-divider">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="2">Rijek Cooking</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Lepas Twisting</th>
                                                    <td class="text-right">
                                                        {{ number_format((float) $reject->lepas_twisting_cooking, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Jatuh</th>
                                                    <td class="text-right">
                                                        {{ number_format((float) $reject->jatuh_cooking, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Potong</th>
                                                    <td class="text-right">
                                                        {{ number_format((float) $reject->potong_cooking, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="font-weight-bold">Total (Kg)</th>
                                                    <td class="text-right font-weight-bold">
                                                        {{ number_format((float) $reject->total_rijek_cooking_kg, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="2">Rijek Packing</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Lepas Twisting</th>
                                                    <td class="text-right">
                                                        {{ number_format((float) $reject->lepas_twisting_packing, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Jatuh</th>
                                                    <td class="text-right">
                                                        {{ number_format((float) $reject->jatuh_packing, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Potong</th>
                                                    <td class="text-right">
                                                        {{ number_format((float) $reject->potong_packing, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="font-weight-bold">Total (Kg)</th>
                                                    <td class="text-right font-weight-bold">
                                                        {{ number_format((float) $reject->total_rijek_packing_kg, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-clipboard d-block"></i>
                            Belum ada data Reject untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 11. PACKING DALAM (single-submit -> card) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">11</span> Packing Dalam</h4>
                </div>
                <div class="card-body">
                    @forelse ($productionBatch->packingDalams as $pd)
                        <div class="entry-divider">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-box">
                                        <div class="info-label">Petugas Pengemasan</div>
                                        <div class="info-value">{{ $pd->petugas_pengemasan ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Awal</div>
                                            <div class="stat-value">
                                                {{ $pd->waktu_pengemasan_awal ? substr($pd->waktu_pengemasan_awal, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Akhir</div>
                                            <div class="stat-value">
                                                {{ $pd->waktu_pengemasan_akhir ? substr($pd->waktu_pengemasan_akhir, 0, 5) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-bars"></i></div>
                                        <div>
                                            <div class="stat-label">Line Manual Single</div>
                                            <div class="stat-value">{{ $pd->line_manual_single ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-bars"></i></div>
                                        <div>
                                            <div class="stat-label">Line Manual Dimsum</div>
                                            <div class="stat-value">{{ $pd->line_manual_dimsum ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-bars"></i></div>
                                        <div>
                                            <div class="stat-label">Line Manual Baso</div>
                                            <div class="stat-value">{{ $pd->line_manual_baso ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                                        <div>
                                            <div class="stat-label">Line Thermoforming 1</div>
                                            <div class="stat-value">{{ $pd->line_thermoforming_1 ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                                        <div>
                                            <div class="stat-label">Line Thermoforming 2</div>
                                            <div class="stat-value">{{ $pd->line_thermoforming_2 ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                                        <div>
                                            <div class="stat-label">Line Thermoforming 3</div>
                                            <div class="stat-value">{{ $pd->line_thermoforming_3 ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-wrench"></i></div>
                                        <div>
                                            <div class="stat-label">Downtime / Kerusakan</div>
                                            <div class="stat-value">{{ $pd->downtime_kerusakan ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Downtime (Menit)</div>
                                            <div class="stat-value text-alert">
                                                {{ $pd->downtime_waktu !== null ? number_format((float) $pd->downtime_waktu, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-box d-block"></i>
                            Belum ada data Packing Dalam untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 12. STANDAR MESIN PACKING DALAM (tabel tetap per batch, satu baris per parameter mesin) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">12</span> Standar Mesin Packing Dalam</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->standarMesinPackingDalams->count())
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
                                    @foreach ($productionBatch->standarMesinPackingDalams as $smpd)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $smpd->parameter_mesin ?? '-' }}</td>
                                            <td>{{ $smpd->penggunaan_mesin_sausage_cutter ?? '-' }}</td>
                                            <td>{{ $smpd->penggunaan_mesin_vacuum_pack ?? '-' }}</td>
                                            <td>{{ $smpd->penggunaan_mesin_thermoforming ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-cogs d-block"></i>
                            Belum ada data Standar Mesin Packing Dalam untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 13. PENGEMASAN PLASTIK PACKING DALAM (tambah baris -> table) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">13</span> Pengemasan Plastik Packing Dalam</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->pengemasanPlastikPackingDalams->count())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Jenis Plastik</th>
                                        <th>No MD</th>
                                        <th class="text-right">Qty Pack (Pcs)</th>
                                        <th class="text-right">Pemakaian (Kg)</th>
                                        <th class="text-right">Sisa (Kg)</th>
                                        <th class="text-right">Reject Plastik (Kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productionBatch->pengemasanPlastikPackingDalams as $ppd)
                                        <tr>
                                            <td>{{ $ppd->jenis_plastik ?? '-' }}</td>
                                            <td>{{ $ppd->no_md ?? '-' }}</td>
                                            <td class="text-right">{{ $ppd->qty_pack ?? '-' }}</td>
                                            <td class="text-right">
                                                {{ $ppd->pemakaian !== null ? number_format((float) $ppd->pemakaian, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $ppd->sisa !== null ? number_format((float) $ppd->sisa, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $ppd->reject_plastik !== null ? number_format((float) $ppd->reject_plastik, 2, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-shopping-bag d-block"></i>
                            Belum ada data Pengemasan Plastik Packing Dalam untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 14. METAL DETECTOR (tabel tetap per batch, satu baris per jenis pemeriksaan) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">14</span> Metal Detector</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->metalDetectors->count())
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
                                    @foreach ($productionBatch->metalDetectors as $md)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $md->jenis_pemeriksaan ?? '-' }}</td>
                                            <td>{{ $md->no_mesin ?? '-' }}</td>
                                            <td>{{ $md->petugas ?? '-' }}</td>
                                            <td>{{ $md->foreman ?? '-' }}</td>
                                            <td>{{ $md->kr ?? '-' }}</td>
                                            <td>{{ $md->waktu_awal ? substr($md->waktu_awal, 0, 5) : '-' }}</td>
                                            <td>{{ $md->waktu_akhir ? substr($md->waktu_akhir, 0, 5) : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-shield-alt d-block"></i>
                            Belum ada data Metal Detector untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 15. SAMPLING PACKING DALAM (sampling -> table) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">15</span> Sampling Packing Dalam</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->samplingPackingDalams->count())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sampling Ke</th>
                                        <th class="text-right">Berat Kemasan (gr)</th>
                                        <th class="text-right">Berat / Bag (gr)</th>
                                        <th class="text-right">Range Berat (gr)</th>
                                        <th class="text-right">Standar Berat (gr)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productionBatch->samplingPackingDalams->sortBy('sampling_ke') as $spd)
                                        <tr>
                                            <td class="text-center">{{ $spd->sampling_ke ?? '-' }}</td>
                                            <td class="text-right">
                                                {{ $spd->berat_kemasan !== null ? number_format((float) $spd->berat_kemasan, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spd->berat_per_bag !== null ? number_format((float) $spd->berat_per_bag, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spd->range_berat !== null ? number_format((float) $spd->range_berat, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spd->standar_berat !== null ? number_format((float) $spd->standar_berat, 2, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-clipboard-list d-block"></i>
                            Belum ada data Sampling Packing Dalam untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 16. PACKING LUAR (single-submit -> card) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">16</span> Packing Luar</h4>
                </div>
                <div class="card-body">
                    @forelse ($productionBatch->packingLuars as $pl)
                        <div class="entry-divider">
                            <div class="mb-3"><span class="badge-soft">{{ $pl->proses_freezing ?? '-' }}</span></div>
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-weight-hanging"></i></div>
                                        <div>
                                            <div class="stat-label">Jumlah Input</div>
                                            <div class="stat-value">
                                                {{ $pl->jumlah_input !== null ? number_format((float) $pl->jumlah_input, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-snowflake"></i></div>
                                        <div>
                                            <div class="stat-label">Suhu IQF (&deg;C)</div>
                                            <div class="stat-value">
                                                {{ $pl->suhu_iqf !== null ? number_format((float) $pl->suhu_iqf, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-thermometer-half"></i></div>
                                        <div>
                                            <div class="stat-label">Suhu Produk (&deg;C)</div>
                                            <div class="stat-value">
                                                {{ $pl->suhu_produk !== null ? number_format((float) $pl->suhu_produk, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                                        <div>
                                            <div class="stat-label">Dweling Time</div>
                                            <div class="stat-value">{{ $pl->dweling_time ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Awal</div>
                                            <div class="stat-value">
                                                {{ $pl->waktu_awal ? substr($pl->waktu_awal, 0, 5) : '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-stop-circle"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Akhir</div>
                                            <div class="stat-value">
                                                {{ $pl->waktu_akhir ? substr($pl->waktu_akhir, 0, 5) : '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-wrench"></i></div>
                                        <div>
                                            <div class="stat-label">Downtime / Kerusakan</div>
                                            <div class="stat-value">{{ $pl->downtime_kerusakan ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                                        <div>
                                            <div class="stat-label">Waktu Downtime (Menit)</div>
                                            <div class="stat-value text-alert">
                                                {{ $pl->downtime_waktu !== null ? number_format((float) $pl->downtime_waktu, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-box d-block"></i>
                            Belum ada data Packing Luar untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 17. PENGEMASAN PACKING LUAR (tabel tetap per batch, satu baris per parameter packing luar) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">17</span> Pengemasan Packing Luar</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->pengemasanPackingLuars->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="60">No</th>
                                        <th>Parameter Packing Luar</th>
                                        <th>No Mesin</th>
                                        <th>Petugas</th>
                                        <th>Foreman</th>
                                        <th>KR</th>
                                        <th>Waktu Awal</th>
                                        <th>Waktu Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productionBatch->pengemasanPackingLuars as $ppl)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $ppl->parameter_packing_luar ?? '-' }}</td>
                                            <td>{{ $ppl->no_mesin ?? '-' }}</td>
                                            <td>{{ $ppl->petugas ?? '-' }}</td>
                                            <td>{{ $ppl->foreman ?? '-' }}</td>
                                            <td>{{ $ppl->kr ?? '-' }}</td>
                                            <td>{{ $ppl->waktu_awal ? substr($ppl->waktu_awal, 0, 5) : '-' }}</td>
                                            <td>{{ $ppl->waktu_akhir ? substr($ppl->waktu_akhir, 0, 5) : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-shopping-bag d-block"></i>
                            Belum ada data Pengemasan Packing Luar untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 18. SAMPLING PACKING LUAR (sampling -> table) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">18</span> Sampling Packing Luar</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->samplingPackingLuars->count())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sampling Ke</th>
                                        <th class="text-right">Berat / Bok (gr)</th>
                                        <th class="text-right">Range Berat (gr)</th>
                                        <th class="text-right">Standar Berat (gr)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productionBatch->samplingPackingLuars->sortBy('sampling_ke') as $spl)
                                        <tr>
                                            <td class="text-center">{{ $spl->sampling_ke ?? '-' }}</td>
                                            <td class="text-right">
                                                {{ $spl->berat_per_bok !== null ? number_format((float) $spl->berat_per_bok, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spl->range_berat !== null ? number_format((float) $spl->range_berat, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $spl->standar_berat !== null ? number_format((float) $spl->standar_berat, 2, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-clipboard-check d-block"></i>
                            Belum ada data Sampling Packing Luar untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 19. REKAPITULASI PACKING LUAR (single-submit -> card) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">19</span> Rekapitulasi Packing Luar</h4>
                </div>
                <div class="card-body">
                    @forelse ($productionBatch->rekapitulasiPackingLuars as $rpl)
                        <div class="entry-divider">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-boxes"></i></div>
                                        <div>
                                            <div class="stat-label">Jumlah Batch</div>
                                            <div class="stat-value">{{ $rpl->jumlah_batch ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-box"></i></div>
                                        <div>
                                            <div class="stat-label">Jumlah Pack</div>
                                            <div class="stat-value">
                                                {{ $rpl->jumlah_pack !== null ? number_format((float) $rpl->jumlah_pack, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-cube"></i></div>
                                        <div>
                                            <div class="stat-label">Jumlah Boks</div>
                                            <div class="stat-value">
                                                {{ $rpl->jumlah_boks !== null ? number_format((float) $rpl->jumlah_boks, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-weight"></i></div>
                                        <div>
                                            <div class="stat-label">Jumlah Kg</div>
                                            <div class="stat-value">
                                                {{ $rpl->jumlah_kg !== null ? number_format((float) $rpl->jumlah_kg, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                                        <div>
                                            <div class="stat-label">No. BSTB</div>
                                            <div class="stat-value">{{ $rpl->no_bstb ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-dolly"></i></div>
                                        <div>
                                            <div class="stat-label">WIP Keluar (Bag)</div>
                                            <div class="stat-value">
                                                {{ $rpl->jumlah_wip_keluar_bag !== null ? number_format((float) $rpl->jumlah_wip_keluar_bag, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-weight-hanging"></i></div>
                                        <div>
                                            <div class="stat-label">WIP Keluar (Kg)</div>
                                            <div class="stat-value">
                                                {{ $rpl->jumlah_wip_keluar_kg !== null ? number_format((float) $rpl->jumlah_wip_keluar_kg, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                                        <div>
                                            <div class="stat-label">Tanggal Transfer</div>
                                            <div class="stat-value">
                                                {{ $rpl->tanggal_transfer ? $rpl->tanggal_transfer->format('d M Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-arrow-right"></i></div>
                                        <div>
                                            <div class="stat-label">WIP Masuk</div>
                                            <div class="stat-value">{{ $rpl->wip_masuk ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-arrow-down"></i></div>
                                        <div>
                                            <div class="stat-label">Jumlah WIP Masuk</div>
                                            <div class="stat-value">
                                                {{ $rpl->jumlah_wip_masuk !== null ? number_format((float) $rpl->jumlah_wip_masuk, 2, ',', '.') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-clipboard-check"></i></div>
                                        <div>
                                            <div class="stat-label">Checker</div>
                                            <div class="stat-value">{{ $rpl->checker ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-icon"><i class="fas fa-id-badge"></i></div>
                                        <div>
                                            <div class="stat-label">KR</div>
                                            <div class="stat-value">{{ $rpl->kr ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="process-empty">
                            <i class="fas fa-chart-bar d-block"></i>
                            Belum ada data Rekapitulasi Packing Luar untuk production batch ini.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 20. KARTON BOX PACKING LUAR (tambah baris -> table) --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h4><span class="step-badge">20</span> Karton Box Packing Luar</h4>
                </div>
                <div class="card-body p-0">
                    @if ($productionBatch->kartonBoxPackingLuar->count())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Jenis Karton Box</th>
                                        <th class="text-right">Qty Box</th>
                                        <th class="text-right">Pemakaian</th>
                                        <th class="text-right">Sisa</th>
                                        <th class="text-right">Reject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productionBatch->kartonBoxPackingLuar as $kbpl)
                                        <tr>
                                            <td>{{ $kbpl->jenis_karton_box ?? '-' }}</td>
                                            <td class="text-right">
                                                {{ $kbpl->qty_box !== null ? number_format((float) $kbpl->qty_box, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $kbpl->pemakaian !== null ? number_format((float) $kbpl->pemakaian, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $kbpl->sisa !== null ? number_format((float) $kbpl->sisa, 2, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-right">
                                                {{ $kbpl->reject !== null ? number_format((float) $kbpl->reject, 2, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="process-empty">
                            <i class="fas fa-archive d-block"></i>
                            Belum ada data Karton Box Packing Luar untuk production batch ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="card card-final">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: .5rem;">
                        <a href="{{ route('manager.production-batch.index') }}" class="btn btn-ghost">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>

                        <a href="{{ route('manager.production-batch.export', $productionBatch->id) }}"
                            class="btn btn-excel">
                            <i class="fas fa-file-excel mr-1"></i>
                            Excel
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
