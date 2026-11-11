<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KartonBoxPackingLuarController;
use App\Http\Controllers\MetalDetectorController;
use App\Http\Controllers\MonitoringLineBasoController;
use App\Http\Controllers\MonitoringPemasakanController;
use App\Http\Controllers\PackingDalamController;
use App\Http\Controllers\PackingLuarController;
use App\Http\Controllers\ParameterPemasakanController;
use App\Http\Controllers\ParameterProdukController;
use App\Http\Controllers\PengemasanPackingLuarController;
use App\Http\Controllers\PengemasanPlastikPackingDalamController;
use App\Http\Controllers\StandarParameterProdukController;
use App\Http\Controllers\PenggunaanMesinController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFormulaController;
use App\Http\Controllers\ProductionBatchController;
use App\Http\Controllers\ProduksiBahanBakuController;
use App\Http\Controllers\RejectController;
use App\Http\Controllers\RekapitulasiPackingLuarController;
use App\Http\Controllers\SamplingPackingDalamController;
use App\Http\Controllers\SamplingPackingLuarController;
use App\Http\Controllers\StandarMesinPackingDalamController;
use App\Http\Controllers\SuhuAreaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'createLogin'])->name('login');
Route::post('/store', [AuthController::class, 'storeLogin'])->name('login.store');

Route::middleware(['auth'])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('password/edit', [AuthController::class, 'edit'])->name('password.edit');
    Route::put('password/update', [AuthController::class, 'update'])->name('password.update');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/produksi-bahan-baku/get-formulas/{productionBatchId}', [ProduksiBahanBakuController::class, 'getFormulas'])->name('produksi-bahan-baku.get-formulas');
});

Route::prefix('operator')->middleware(['auth', 'role:Operator'])->group(function() {
    Route::prefix('bahan-baku')->group(function () {
        Route::get('/', [BahanBakuController::class, 'index'])->name('operator.bahan-baku.index');
        Route::get('/create', [BahanBakuController::class, 'create'])->name('operator.bahan-baku.create');
        Route::post('/store', [BahanBakuController::class, 'store'])->name('operator.bahan-baku.store');
        Route::get('/import', [BahanBakuController::class, 'importPage'])->name('operator.bahan-baku.import');
        Route::post('/import', [BahanBakuController::class, 'upload'])->name('operator.bahan-baku.upload');
        Route::get('/{id}', [BahanBakuController::class, 'detail'])->name('operator.bahan-baku.detail');
        Route::get('/{id}/edit', [BahanBakuController::class, 'edit'])->name('operator.bahan-baku.edit');
        Route::put('/{id}/update', [BahanBakuController::class, 'update'])->name('operator.bahan-baku.update');
        Route::delete('/{id}/delete', [BahanBakuController::class, 'destroy'])->name('operator.bahan-baku.destroy');
        Route::post('/bulk-destroy', [BahanBakuController::class, 'bulkDestroy'])->name('operator.bahan-baku.bulk-destroy');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('operator.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('operator.product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('operator.product.store');
        Route::get('/import', [ProductController::class, 'importPage'])->name('operator.product.import');
        Route::post('/import', [ProductController::class, 'upload'])->name('operator.product.upload');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('operator.product.edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('operator.product.update');
        Route::delete('/{id}/delete', [ProductController::class, 'destroy'])->name('operator.product.destroy');
        Route::post('/bulk-destroy', [ProductController::class, 'bulkDestroy'])->name('operator.product.bulk-destroy');

        Route::get('/formula/import', [ProductFormulaController::class, 'importPage'])->name('operator.product.formula.import');
        Route::post('/formula/import', [ProductFormulaController::class, 'upload'])->name('operator.product.formula.upload');
        Route::post('/formula/bulk-destroy', [ProductFormulaController::class, 'bulkDestroy'])->name('operator.product.formula.bulk-destroy');

        Route::get('/{product}/formula', [ProductFormulaController::class, 'index'])->name('operator.product.formula.index');
        Route::post('/{product}/formula/store', [ProductFormulaController::class, 'store'])->name('operator.product.formula.store');
        Route::put('/formula/{id}/update', [ProductFormulaController::class, 'update'])->name('operator.product.formula.update');
        Route::delete('/formula/{id}/delete', [ProductFormulaController::class, 'destroy'])->name('operator.product.formula.destroy');
        Route::get('/{product}/bahan-baku-json', [ProductFormulaController::class, 'getBahanBakuByProduct'])->name('operator.product.bahan-baku-json');
    });

    Route::prefix('production-batch')->group(function () {
        Route::get('/', [ProductionBatchController::class, 'index'])->name('operator.production-batch.index');
        Route::get('/create', [ProductionBatchController::class, 'create'])->name('operator.production-batch.create');
        Route::post('/store', [ProductionBatchController::class, 'store'])->name('operator.production-batch.store');
        Route::get('/by-date/{date}', [ProductionBatchController::class, 'getByDate'])->name('operator.production-batch.by-date');
        Route::get('/{id}/edit', [ProductionBatchController::class, 'edit'])->name('operator.production-batch.edit');
        Route::put('/{id}/update', [ProductionBatchController::class, 'update'])->name('operator.production-batch.update');
        Route::delete('/{id}/delete', [ProductionBatchController::class, 'destroy'])->name('operator.production-batch.destroy');
        Route::get('/{id}', [ProductionBatchController::class, 'detail'])->name('operator.production-batch.detail');
        Route::get('/{id}/export', [ProductionBatchController::class, 'export'])->name('operator.production-batch.export');    
    });

    Route::prefix('produksi-bahan-baku')->group(function () {
        Route::get('/', [ProduksiBahanBakuController::class, 'index'])->name('operator.produksi-bahan-baku.index');
        Route::get('/create', [ProduksiBahanBakuController::class, 'create'])->name('operator.produksi-bahan-baku.create');
        Route::post('/store', [ProduksiBahanBakuController::class, 'store'])->name('operator.produksi-bahan-baku.store');
        Route::get('/{id}/detail', [ProduksiBahanBakuController::class, 'detail'])->name('operator.produksi-bahan-baku.detail');
        Route::get('/{id}/edit', [ProduksiBahanBakuController::class, 'edit'])->name('operator.produksi-bahan-baku.edit');
        Route::put('/{id}/update', [ProduksiBahanBakuController::class, 'update'])->name('operator.produksi-bahan-baku.update');
        Route::delete('/{id}/delete', [ProduksiBahanBakuController::class, 'destroy'])->name('operator.produksi-bahan-baku.destroy');
        Route::post('/item/bulk-destroy', [ProduksiBahanBakuController::class, 'bulkDestroyItems'])->name('operator.produksi-bahan-baku.item.bulk-destroy');     
    });

    Route::prefix('penggunaan-mesin')->group(function () {
        Route::get('/', [PenggunaanMesinController::class, 'index'])->name('operator.penggunaan-mesin.index');
        Route::get('/create', [PenggunaanMesinController::class, 'create'])->name('operator.penggunaan-mesin.create');
        Route::post('/store', [PenggunaanMesinController::class, 'store'])->name('operator.penggunaan-mesin.store');
        Route::post('/bulk-destroy', [PenggunaanMesinController::class, 'bulkDestroy'])->name('operator.penggunaan-mesin.bulk-destroy');
        Route::get('/{id}/edit', [PenggunaanMesinController::class, 'edit'])->name('operator.penggunaan-mesin.edit');
        Route::put('/{id}/update', [PenggunaanMesinController::class, 'update'])->name('operator.penggunaan-mesin.update');
        Route::delete('/{id}/delete', [PenggunaanMesinController::class, 'destroy'])->name('operator.penggunaan-mesin.destroy');
        Route::get('/{id}', [PenggunaanMesinController::class, 'detail'])->name('operator.penggunaan-mesin.detail');
    });

    Route::prefix('parameter-produk')->group(function () {
        Route::get('/', [ParameterProdukController::class, 'index'])->name('operator.parameter-produk.index');
        Route::get('/create', [ParameterProdukController::class, 'create'])->name('operator.parameter-produk.create');
        Route::post('/store', [ParameterProdukController::class, 'store'])->name('operator.parameter-produk.store');
        Route::get('/{id}/detail', [ParameterProdukController::class, 'detail'])->name('operator.parameter-produk.detail');
        Route::get('parameter-produk/{productionBatchId}/edit', [ParameterProdukController::class, 'edit'])->name('operator.parameter-produk.edit');
Route::put('parameter-produk/{productionBatchId}', [ParameterProdukController::class, 'update'])->name('operator.parameter-produk.update');
        Route::delete('/{id}/delete', [ParameterProdukController::class, 'destroy'])->name('operator.parameter-produk.destroy');
        Route::post('/bulk-destroy', [ParameterProdukController::class, 'bulkDestroy'])->name('operator.parameter-produk.bulk-destroy');
    });

    Route::prefix('standar-parameter-produk')->group(function () {
        Route::get('/', [StandarParameterProdukController::class, 'index'])->name('operator.standar-parameter-produk.index');
        Route::get('/create', [StandarParameterProdukController::class, 'create'])->name('operator.standar-parameter-produk.create');
        Route::post('/store', [StandarParameterProdukController::class, 'store'])->name('operator.standar-parameter-produk.store');
        Route::get('/import', [StandarParameterProdukController::class, 'importPage'])->name('operator.standar-parameter-produk.import');
        Route::post('/import', [StandarParameterProdukController::class, 'upload'])->name('operator.standar-parameter-produk.upload');
        Route::get('/{productionBatchId}/detail', [StandarParameterProdukController::class, 'detail'])->name('operator.standar-parameter-produk.detail');
        Route::get('/{id}/edit', [StandarParameterProdukController::class, 'edit'])->name('operator.standar-parameter-produk.edit');
        Route::put('/{id}/update', [StandarParameterProdukController::class, 'update'])->name('operator.standar-parameter-produk.update');
        Route::delete('/{id}/delete', [StandarParameterProdukController::class, 'destroy'])->name('operator.standar-parameter-produk.destroy');
    });

    Route::prefix('reject')->group(function () {
        Route::get('/', [RejectController::class, 'index'])->name('operator.reject.index');
        Route::get('/create', [RejectController::class, 'create'])->name('operator.reject.create');
        Route::post('/store', [RejectController::class, 'store'])->name('operator.reject.store');
        Route::get('/{id}/detail', [RejectController::class, 'detail'])->name('operator.reject.detail');
        Route::get('/{id}/edit', [RejectController::class, 'edit'])->name('operator.reject.edit');
        Route::put('/{id}/update', [RejectController::class, 'update'])->name('operator.reject.update');
        Route::delete('/{id}/delete', [RejectController::class, 'destroy'])->name('operator.reject.destroy');
    });

    Route::prefix('suhu-area')->group(function () {
        Route::get('/', [SuhuAreaController::class, 'index'])->name('operator.suhu-area.index');
        Route::get('/create', [SuhuAreaController::class, 'create'])->name('operator.suhu-area.create');
        Route::post('/store', [SuhuAreaController::class, 'store'])->name('operator.suhu-area.store');
        Route::get('/{id}/detail', [SuhuAreaController::class, 'detail'])->name('operator.suhu-area.detail');
        Route::get('/{id}/edit', [SuhuAreaController::class, 'edit'])->name('operator.suhu-area.edit');
        Route::put('/{id}/update', [SuhuAreaController::class, 'update'])->name('operator.suhu-area.update');
        Route::delete('/{id}/delete', [SuhuAreaController::class, 'destroy'])->name('operator.suhu-area.destroy');
    });

    Route::prefix('parameter-pemasakan')->group(function () {
        Route::get('/', [ParameterPemasakanController::class, 'index'])->name('operator.parameter-pemasakan.index');
        Route::get('/create', [ParameterPemasakanController::class, 'create'])->name('operator.parameter-pemasakan.create');
        Route::post('/store', [ParameterPemasakanController::class, 'store'])->name('operator.parameter-pemasakan.store');
        Route::post('/bulk-destroy', [ParameterPemasakanController::class, 'bulkDestroy'])->name('operator.parameter-pemasakan.bulk-destroy');
        Route::get('/{id}/detail', [ParameterPemasakanController::class, 'detail'])->name('operator.parameter-pemasakan.detail');
        Route::get('/{id}/edit', [ParameterPemasakanController::class, 'edit'])->name('operator.parameter-pemasakan.edit');
        Route::put('/{id}/update', [ParameterPemasakanController::class, 'update'])->name('operator.parameter-pemasakan.update');
        Route::delete('/{id}/delete', [ParameterPemasakanController::class, 'destroy'])->name('operator.parameter-pemasakan.destroy');
    });

    Route::prefix('monitoring-pemasakan')->group(function () {
        Route::get('/', [MonitoringPemasakanController::class, 'index'])->name('operator.monitoring-pemasakan.index');
        Route::get('/create', [MonitoringPemasakanController::class, 'create'])->name('operator.monitoring-pemasakan.create');
        Route::post('/store', [MonitoringPemasakanController::class, 'store'])->name('operator.monitoring-pemasakan.store');
        Route::post('/bulk-destroy', [MonitoringPemasakanController::class, 'bulkDestroy'])->name('operator.monitoring-pemasakan.bulk-destroy');
        Route::get('/{id}/detail', [MonitoringPemasakanController::class, 'detail'])->name('operator.monitoring-pemasakan.detail');
        Route::get('/{id}/edit', [MonitoringPemasakanController::class, 'edit'])->name('operator.monitoring-pemasakan.edit');
        Route::put('/{id}/update', [MonitoringPemasakanController::class, 'update'])->name('operator.monitoring-pemasakan.update');
        Route::delete('/{id}/delete', [MonitoringPemasakanController::class, 'destroy'])->name('operator.monitoring-pemasakan.destroy');
    });

    Route::prefix('monitoring-line-baso')->group(function () {
        Route::get('/', [MonitoringLineBasoController::class, 'index'])->name('operator.monitoring-line-baso.index');
        Route::get('/create', [MonitoringLineBasoController::class, 'create'])->name('operator.monitoring-line-baso.create');
        Route::post('/store', [MonitoringLineBasoController::class, 'store'])->name('operator.monitoring-line-baso.store');
        Route::post('/bulk-destroy', [MonitoringLineBasoController::class, 'bulkDestroy'])->name('operator.monitoring-line-baso.bulk-destroy');
        Route::get('/{id}/detail', [MonitoringLineBasoController::class, 'detail'])->name('operator.monitoring-line-baso.detail');
        Route::get('/{id}/edit', [MonitoringLineBasoController::class, 'edit'])->name('operator.monitoring-line-baso.edit');
        Route::put('/{id}/update', [MonitoringLineBasoController::class, 'update'])->name('operator.monitoring-line-baso.update');
        Route::delete('/{id}/delete', [MonitoringLineBasoController::class, 'destroy'])->name('operator.monitoring-line-baso.destroy');
    });

    Route::prefix('packing-dalam')->group(function () {
        Route::get('/', [PackingDalamController::class, 'index'])->name('operator.packing-dalam.index');
        Route::get('/create', [PackingDalamController::class, 'create'])->name('operator.packing-dalam.create');
        Route::post('/store', [PackingDalamController::class, 'store'])->name('operator.packing-dalam.store');
        Route::post('/bulk-destroy', [PackingDalamController::class, 'bulkDestroy'])->name('operator.packing-dalam.bulk-destroy');
        Route::get('/{id}/detail', [PackingDalamController::class, 'detail'])->name('operator.packing-dalam.detail');
        Route::get('/{id}/edit', [PackingDalamController::class, 'edit'])->name('operator.packing-dalam.edit');
        Route::put('/{id}/update', [PackingDalamController::class, 'update'])->name('operator.packing-dalam.update');
        Route::delete('/{id}/delete', [PackingDalamController::class, 'destroy'])->name('operator.packing-dalam.destroy');
    });

    Route::prefix('standar-mesin-packing-dalam')->group(function () {
        Route::get('/', [StandarMesinPackingDalamController::class, 'index'])->name('operator.standar-mesin-packing-dalam.index');
        Route::get('/create', [StandarMesinPackingDalamController::class, 'create'])->name('operator.standar-mesin-packing-dalam.create');
        Route::post('/store', [StandarMesinPackingDalamController::class, 'store'])->name('operator.standar-mesin-packing-dalam.store');
        Route::post('/bulk-destroy', [StandarMesinPackingDalamController::class, 'bulkDestroy'])->name('operator.standar-mesin-packing-dalam.bulk-destroy');
        Route::get('/{id}/detail', [StandarMesinPackingDalamController::class, 'detail'])->name('operator.standar-mesin-packing-dalam.detail');
        Route::get('/{id}/edit', [StandarMesinPackingDalamController::class, 'edit'])->name('operator.standar-mesin-packing-dalam.edit');
        Route::put('/{id}/update', [StandarMesinPackingDalamController::class, 'update'])->name('operator.standar-mesin-packing-dalam.update');
        Route::delete('/{id}/delete', [StandarMesinPackingDalamController::class, 'destroy'])->name('operator.standar-mesin-packing-dalam.destroy');
    });

    Route::prefix('pengemasan-plastik-packing-dalam')->group(function () {
        Route::get('/', [PengemasanPlastikPackingDalamController::class, 'index'])->name('operator.pengemasan-plastik-packing-dalam.index');
        Route::get('/create', [PengemasanPlastikPackingDalamController::class, 'create'])->name('operator.pengemasan-plastik-packing-dalam.create');
        Route::post('/store', [PengemasanPlastikPackingDalamController::class, 'store'])->name('operator.pengemasan-plastik-packing-dalam.store');
        Route::get('/{id}/detail', [PengemasanPlastikPackingDalamController::class, 'detail'])->name('operator.pengemasan-plastik-packing-dalam.detail');
        Route::get('/{id}/edit', [PengemasanPlastikPackingDalamController::class, 'edit'])->name('operator.pengemasan-plastik-packing-dalam.edit');
        Route::put('/{id}/update', [PengemasanPlastikPackingDalamController::class, 'update'])->name('operator.pengemasan-plastik-packing-dalam.update');
        Route::delete('/{id}/delete', [PengemasanPlastikPackingDalamController::class, 'destroy'])->name('operator.pengemasan-plastik-packing-dalam.destroy');
        Route::post('/item/bulk-destroy', [PengemasanPlastikPackingDalamController::class, 'bulkDestroyItems'])->name('operator.pengemasan-plastik-packing-dalam.item.bulk-destroy');
    });

    Route::prefix('metal-detector')->group(function () {
        Route::get('/', [MetalDetectorController::class, 'index'])->name('operator.metal-detector.index');
        Route::get('/create', [MetalDetectorController::class, 'create'])->name('operator.metal-detector.create');
        Route::post('/store', [MetalDetectorController::class, 'store'])->name('operator.metal-detector.store');
        Route::post('/bulk-destroy', [MetalDetectorController::class, 'bulkDestroy'])->name('operator.metal-detector.bulk-destroy');
        Route::get('/{id}/detail', [MetalDetectorController::class, 'detail'])->name('operator.metal-detector.detail');
        Route::get('/{id}/edit', [MetalDetectorController::class, 'edit'])->name('operator.metal-detector.edit');
        Route::put('/{id}/update', [MetalDetectorController::class, 'update'])->name('operator.metal-detector.update');
        Route::delete('/{id}/delete', [MetalDetectorController::class, 'destroy'])->name('operator.metal-detector.destroy');
    });

    Route::prefix('sampling-packing-dalam')->group(function () {
        Route::get('/', [SamplingPackingDalamController::class, 'index'])->name('operator.sampling-packing-dalam.index');
        Route::get('/create', [SamplingPackingDalamController::class, 'create'])->name('operator.sampling-packing-dalam.create');
        Route::post('/store', [SamplingPackingDalamController::class, 'store'])->name('operator.sampling-packing-dalam.store');
        Route::get('/{productionBatchId}/detail', [SamplingPackingDalamController::class, 'detail'])->name('operator.sampling-packing-dalam.detail');
        Route::get('/{id}/edit', [SamplingPackingDalamController::class, 'edit'])->name('operator.sampling-packing-dalam.edit');
        Route::put('/{id}/update', [SamplingPackingDalamController::class, 'update'])->name('operator.sampling-packing-dalam.update');
        Route::delete('/{id}/delete', [SamplingPackingDalamController::class, 'destroy'])->name('operator.sampling-packing-dalam.destroy');
    });

    Route::prefix('packing-luar')->group(function () {
        Route::get('/', [PackingLuarController::class, 'index'])->name('operator.packing-luar.index');
        Route::get('/create', [PackingLuarController::class, 'create'])->name('operator.packing-luar.create');
        Route::post('/store', [PackingLuarController::class, 'store'])->name('operator.packing-luar.store');
        Route::post('/bulk-destroy', [PackingLuarController::class, 'bulkDestroy'])->name('operator.packing-luar.bulk-destroy');
        Route::get('/{id}/detail', [PackingLuarController::class, 'detail'])->name('operator.packing-luar.detail');
        Route::get('/{id}/edit', [PackingLuarController::class, 'edit'])->name('operator.packing-luar.edit');
        Route::put('/{id}/update', [PackingLuarController::class, 'update'])->name('operator.packing-luar.update');
        Route::delete('/{id}/delete', [PackingLuarController::class, 'destroy'])->name('operator.packing-luar.destroy');
    });

    Route::prefix('pengemasan-packing-luar')->group(function () {
        Route::get('/', [PengemasanPackingLuarController::class, 'index'])->name('operator.pengemasan-packing-luar.index');
        Route::get('/create', [PengemasanPackingLuarController::class, 'create'])->name('operator.pengemasan-packing-luar.create');
        Route::post('/store', [PengemasanPackingLuarController::class, 'store'])->name('operator.pengemasan-packing-luar.store');
        Route::post('/bulk-destroy', [PengemasanPackingLuarController::class, 'bulkDestroy'])->name('operator.pengemasan-packing-luar.bulk-destroy');
        Route::get('/{id}/detail', [PengemasanPackingLuarController::class, 'detail'])->name('operator.pengemasan-packing-luar.detail');
        Route::get('/{id}/edit', [PengemasanPackingLuarController::class, 'edit'])->name('operator.pengemasan-packing-luar.edit');
        Route::put('/{id}/update', [PengemasanPackingLuarController::class, 'update'])->name('operator.pengemasan-packing-luar.update');
        Route::delete('/{id}/delete', [PengemasanPackingLuarController::class, 'destroy'])->name('operator.pengemasan-packing-luar.destroy');
    });

    Route::prefix('sampling-packing-luar')->group(function () {
        Route::get('/', [SamplingPackingLuarController::class, 'index'])->name('operator.sampling-packing-luar.index');
        Route::get('/create', [SamplingPackingLuarController::class, 'create'])->name('operator.sampling-packing-luar.create');
        Route::post('/store', [SamplingPackingLuarController::class, 'store'])->name('operator.sampling-packing-luar.store');
        Route::get('/{productionBatchId}/detail', [SamplingPackingLuarController::class, 'detail'])->name('operator.sampling-packing-luar.detail');
        Route::get('/{id}/edit', [SamplingPackingLuarController::class, 'edit'])->name('operator.sampling-packing-luar.edit');
        Route::put('/{id}/update', [SamplingPackingLuarController::class, 'update'])->name('operator.sampling-packing-luar.update');
        Route::delete('/{id}/delete', [SamplingPackingLuarController::class, 'destroy'])->name('operator.sampling-packing-luar.destroy');
    });

    Route::prefix('rekapitulasi-packing-luar')->group(function () {
        Route::get('/', [RekapitulasiPackingLuarController::class, 'index'])->name('operator.rekapitulasi-packing-luar.index');
        Route::get('/create', [RekapitulasiPackingLuarController::class, 'create'])->name('operator.rekapitulasi-packing-luar.create');
        Route::post('/store', [RekapitulasiPackingLuarController::class, 'store'])->name('operator.rekapitulasi-packing-luar.store');
        Route::post('/bulk-destroy', [RekapitulasiPackingLuarController::class, 'bulkDestroy'])->name('operator.rekapitulasi-packing-luar.bulk-destroy');
        Route::get('/{id}/detail', [RekapitulasiPackingLuarController::class, 'detail'])->name('operator.rekapitulasi-packing-luar.detail');
        Route::get('/{id}/edit', [RekapitulasiPackingLuarController::class, 'edit'])->name('operator.rekapitulasi-packing-luar.edit');
        Route::put('/{id}/update', [RekapitulasiPackingLuarController::class, 'update'])->name('operator.rekapitulasi-packing-luar.update');
        Route::delete('/{id}/delete', [RekapitulasiPackingLuarController::class, 'destroy'])->name('operator.rekapitulasi-packing-luar.destroy');
    });

    Route::prefix('karton-box-packing-luar')->group(function () {
        Route::get('/', [KartonBoxPackingLuarController::class, 'index'])->name('operator.karton-box-packing-luar.index');
        Route::get('/create', [KartonBoxPackingLuarController::class, 'create'])->name('operator.karton-box-packing-luar.create');
        Route::post('/store', [KartonBoxPackingLuarController::class, 'store'])->name('operator.karton-box-packing-luar.store');
        Route::get('/{id}/detail', [KartonBoxPackingLuarController::class, 'detail'])->name('operator.karton-box-packing-luar.detail');
        Route::get('/{id}/edit', [KartonBoxPackingLuarController::class, 'edit'])->name('operator.karton-box-packing-luar.edit');
        Route::put('/{id}/update', [KartonBoxPackingLuarController::class, 'update'])->name('operator.karton-box-packing-luar.update');
        Route::delete('/{id}/delete', [KartonBoxPackingLuarController::class, 'destroy'])->name('operator.karton-box-packing-luar.destroy');
        Route::post('/item/bulk-destroy', [KartonBoxPackingLuarController::class, 'bulkDestroyItems'])->name('operator.karton-box-packing-luar.item.bulk-destroy');
    });
});

Route::prefix('manager')->middleware(['auth', 'role:Manager'])->group(function () {
    Route::prefix('production-batch')->group(function () {
        Route::get('/', [ProductionBatchController::class, 'managerIndex'])->name('manager.production-batch.index');
        Route::get('/{id}', [ProductionBatchController::class, 'managerDetail'])->name('manager.production-batch.detail');
        Route::get('/{id}/export', [ProductionBatchController::class, 'managerExport'])->name('manager.production-batch.export');    
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('manager.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('manager.user.create');
        Route::post('/store', [UserController::class, 'store'])->name('manager.user.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('manager.user.edit');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('manager.user.update');
        Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('manager.user.destroy');
    });

    Route::prefix('produksi-bahan-baku')->group(function () {
        Route::get('/', [ProduksiBahanBakuController::class, 'managerIndex'])->name('manager.produksi-bahan-baku.index');
        Route::get('/{id}/detail', [ProduksiBahanBakuController::class, 'managerDetail'])->name('manager.produksi-bahan-baku.detail');
    });

    Route::prefix('penggunaan-mesin')->group(function () {
        Route::get('/', [PenggunaanMesinController::class, 'managerIndex'])->name('manager.penggunaan-mesin.index');
        Route::get('/{id}', [PenggunaanMesinController::class, 'managerDetail'])->name('manager.penggunaan-mesin.detail');
    });

    Route::prefix('parameter-produk')->group(function () {
        Route::get('/', [ParameterProdukController::class, 'managerIndex'])->name('manager.parameter-produk.index');
        Route::get('/{id}/detail', [ParameterProdukController::class, 'managerDetail'])->name('manager.parameter-produk.detail');
    });

    Route::prefix('standar-parameter-produk')->group(function () {
        Route::get('/', [StandarParameterProdukController::class, 'managerIndex'])->name('manager.standar-parameter-produk.index');
        Route::get('/{productionBatchId}/detail', [StandarParameterProdukController::class, 'managerDetail'])->name('manager.standar-parameter-produk.detail');
    });

    Route::prefix('reject')->group(function () {
        Route::get('/', [RejectController::class, 'managerIndex'])->name('manager.reject.index');
        Route::get('/{id}/detail', [RejectController::class, 'managerDetail'])->name('manager.reject.detail');
    });

    Route::prefix('suhu-area')->group(function () {
        Route::get('/', [SuhuAreaController::class, 'managerIndex'])->name('manager.suhu-area.index');
        Route::get('/{id}/detail', [SuhuAreaController::class, 'managerDetail'])->name('manager.suhu-area.detail');
    });

    Route::prefix('parameter-pemasakan')->group(function () {
        Route::get('/', [ParameterPemasakanController::class, 'managerIndex'])->name('manager.parameter-pemasakan.index');
        Route::get('/{id}/detail', [ParameterPemasakanController::class, 'managerDetail'])->name('manager.parameter-pemasakan.detail');
    });

    Route::prefix('monitoring-pemasakan')->group(function () {
        Route::get('/', [MonitoringPemasakanController::class, 'managerIndex'])->name('manager.monitoring-pemasakan.index');
        Route::get('/{id}/detail', [MonitoringPemasakanController::class, 'managerDetail'])->name('manager.monitoring-pemasakan.detail');
    });

    Route::prefix('monitoring-line-baso')->group(function () {
        Route::get('/', [MonitoringLineBasoController::class, 'managerIndex'])->name('manager.monitoring-line-baso.index');
        Route::get('/{id}/detail', [MonitoringLineBasoController::class, 'managerDetail'])->name('manager.monitoring-line-baso.detail');
    });

    Route::prefix('packing-dalam')->group(function () {
        Route::get('/', [PackingDalamController::class, 'managerIndex'])->name('manager.packing-dalam.index');
        Route::get('/{id}/detail', [PackingDalamController::class, 'managerDetail'])->name('manager.packing-dalam.detail');
    });

    Route::prefix('standar-mesin-packing-dalam')->group(function () {
        Route::get('/', [StandarMesinPackingDalamController::class, 'managerIndex'])->name('manager.standar-mesin-packing-dalam.index');
        Route::get('/{id}/detail', [StandarMesinPackingDalamController::class, 'managerDetail'])->name('manager.standar-mesin-packing-dalam.detail');
    });

    Route::prefix('pengemasan-plastik-packing-dalam')->group(function () {
        Route::get('/', [PengemasanPlastikPackingDalamController::class, 'managerIndex'])->name('manager.pengemasan-plastik-packing-dalam.index');
        Route::get('/{id}/detail', [PengemasanPlastikPackingDalamController::class, 'managerDetail'])->name('manager.pengemasan-plastik-packing-dalam.detail');
    });

    Route::prefix('metal-detector')->group(function () {
        Route::get('/', [MetalDetectorController::class, 'managerIndex'])->name('manager.metal-detector.index');
        Route::get('/{id}/detail', [MetalDetectorController::class, 'managerDetail'])->name('manager.metal-detector.detail');
    });

    Route::prefix('sampling-packing-dalam')->group(function () {
        Route::get('/', [SamplingPackingDalamController::class, 'managerIndex'])->name('manager.sampling-packing-dalam.index');
        Route::get('/{productionBatchId}/detail', [SamplingPackingDalamController::class, 'managerDetail'])->name('manager.sampling-packing-dalam.detail');
    });

    Route::prefix('packing-luar')->group(function () {
        Route::get('/', [PackingLuarController::class, 'managerIndex'])->name('manager.packing-luar.index');
        Route::get('/{id}/detail', [PackingLuarController::class, 'managerDetail'])->name('manager.packing-luar.detail');
    });

    Route::prefix('pengemasan-packing-luar')->group(function () {
        Route::get('/', [PengemasanPackingLuarController::class, 'managerIndex'])->name('manager.pengemasan-packing-luar.index');
        Route::get('/{id}/detail', [PengemasanPackingLuarController::class, 'managerDetail'])->name('manager.pengemasan-packing-luar.detail');
    });

    Route::prefix('sampling-packing-luar')->group(function () {
        Route::get('/', [SamplingPackingLuarController::class, 'managerIndex'])->name('manager.sampling-packing-luar.index');
        Route::get('/{productionBatchId}/detail', [SamplingPackingLuarController::class, 'managerDetail'])->name('manager.sampling-packing-luar.detail');
    });

    Route::prefix('rekapitulasi-packing-luar')->group(function () {
        Route::get('/', [RekapitulasiPackingLuarController::class, 'managerIndex'])->name('manager.rekapitulasi-packing-luar.index');
        Route::get('/{id}/detail', [RekapitulasiPackingLuarController::class, 'managerDetail'])->name('manager.rekapitulasi-packing-luar.detail');
    });

    Route::prefix('karton-box-packing-luar')->group(function () {
        Route::get('/', [KartonBoxPackingLuarController::class, 'managerIndex'])->name('manager.karton-box-packing-luar.index');
        Route::get('/{id}/detail', [KartonBoxPackingLuarController::class, 'managerDetail'])->name('manager.karton-box-packing-luar.detail');
    });
});