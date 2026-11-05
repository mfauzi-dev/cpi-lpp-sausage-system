@extends('layouts.master')

@section('title', 'Edit Standar Mesin Packing Dalam')

@section('content')
    <div class="page-section">
        <div class="section-header">
            <h1>Edit Standar Mesin Packing Dalam</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('operator.standar-mesin-packing-dalam.index') }}">Standar Mesin Packing Dalam</a>
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

            <form action="{{ route('operator.standar-mesin-packing-dalam.update', $productionBatch->id) }}" method="POST">
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
                                        {{ $productionBatch->tanggal ? \Carbon\Carbon::parse($productionBatch->tanggal)->format('d-m-Y') : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Product</div>
                                    <div class="info-value">{{ $productionBatch->product?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Kode Batch</div>
                                    <div class="info-value">{{ $productionBatch->kode_batch ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="info-label">Shift</div>
                                    <div class="info-value">{{ $productionBatch->shift ?? '-' }}</div>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-wide" id="tableStandar">
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
                                    @foreach ($parameterList as $i => $parameter)
                                        @php
                                            $data = $dataStandar[$parameter] ?? null;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $parameter }}
                                                <input type="hidden" name="standar[{{ $i }}][parameter_mesin]"
                                                    value="{{ $parameter }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="standar[{{ $i }}][penggunaan_mesin_sausage_cutter]"
                                                    class="form-control"
                                                    value="{{ old("standar.$i.penggunaan_mesin_sausage_cutter", $data->penggunaan_mesin_sausage_cutter ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="standar[{{ $i }}][penggunaan_mesin_vacuum_pack]"
                                                    class="form-control"
                                                    value="{{ old("standar.$i.penggunaan_mesin_vacuum_pack", $data->penggunaan_mesin_vacuum_pack ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="standar[{{ $i }}][penggunaan_mesin_thermoforming]"
                                                    class="form-control"
                                                    value="{{ old("standar.$i.penggunaan_mesin_thermoforming", $data->penggunaan_mesin_thermoforming ?? '') }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-4">
                    <a href="{{ route('operator.standar-mesin-packing-dalam.index') }}" class="btn btn-ghost mb-2">
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
