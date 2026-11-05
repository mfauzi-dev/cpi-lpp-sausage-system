<?php

namespace App\Http\Controllers;

use App\Models\ParameterPemasakan;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ParameterPemasakanController extends Controller
{
    public function index(Request $request)
    {
        $query = ParameterPemasakan::with('productionBatch')->latest();
 
        if ($request->filled('kode_batch')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
            });
        }
 
        if ($request->filled('date_from')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->whereDate('tanggal', '>=', $request->date_from);
            });
        }
 
        if ($request->filled('date_to')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->whereDate('tanggal', '<=', $request->date_to);
            });
        }
 
        if ($request->filled('shift')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->where('shift', $request->shift);
            });
        }
 
        $parameterPemasakans = $query->paginate(10)->withQueryString();
 
        return view('pages.operator.parameter-pemasakan.index', compact('parameterPemasakans'));
    }
 
    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.parameter-pemasakan.create', compact('productionBatches'));
    }
 
    public function detail($id)
    {
        $parameterPemasakan = ParameterPemasakan::with('productionBatch.product')->findOrFail($id);
 
        return view('pages.operator.parameter-pemasakan.detail', compact('parameterPemasakan'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'penggunaan_mesin' => ['nullable', 'string', 'max:255'],
            'drying_1_suhu' => ['nullable', 'numeric'],
            'drying_1_rh' => ['nullable', 'numeric'],
            'drying_1_waktu' => ['nullable', 'numeric'],
            'drying_2_suhu' => ['nullable', 'numeric'],
            'drying_2_rh' => ['nullable', 'numeric'],
            'drying_2_waktu' => ['nullable', 'numeric'],
            'drying_3_suhu' => ['nullable', 'numeric'],
            'drying_3_rh' => ['nullable', 'numeric'],
            'drying_3_waktu' => ['nullable', 'numeric'],
            'cooking_suhu' => ['nullable', 'numeric'],
            'cooking_rh' => ['nullable', 'numeric'],
            'cooking_waktu' => ['nullable', 'numeric'],
            'smoke_suhu' => ['nullable', 'numeric'],
            'smoke_rh' => ['nullable', 'numeric'],
            'smoke_waktu' => ['nullable', 'numeric'],
            'drying_4_suhu' => ['nullable', 'numeric'],
            'drying_4_rh' => ['nullable', 'numeric'],
            'drying_4_waktu' => ['nullable', 'numeric'],
            'suhu_produk_matang' => ['nullable', 'numeric'],
        ]);
 
        DB::beginTransaction();
 
        try {
            ParameterPemasakan::create([
                'production_batch_id' => $request->production_batch_id,
                'penggunaan_mesin' => $request->penggunaan_mesin,
                'drying_1_suhu' => $request->drying_1_suhu,
                'drying_1_rh' => $request->drying_1_rh,
                'drying_1_waktu' => $request->drying_1_waktu,
                'drying_2_suhu' => $request->drying_2_suhu,
                'drying_2_rh' => $request->drying_2_rh,
                'drying_2_waktu' => $request->drying_2_waktu,
                'drying_3_suhu' => $request->drying_3_suhu,
                'drying_3_rh' => $request->drying_3_rh,
                'drying_3_waktu' => $request->drying_3_waktu,
                'cooking_suhu' => $request->cooking_suhu,
                'cooking_rh' => $request->cooking_rh,
                'cooking_waktu' => $request->cooking_waktu,
                'smoke_suhu' => $request->smoke_suhu,
                'smoke_rh' => $request->smoke_rh,
                'smoke_waktu' => $request->smoke_waktu,
                'drying_4_suhu' => $request->drying_4_suhu,
                'drying_4_rh' => $request->drying_4_rh,
                'drying_4_waktu' => $request->drying_4_waktu,
                'suhu_produk_matang' => $request->suhu_produk_matang,
            ]);
 
            DB::commit();
 
            return redirect()
                ->route('operator.parameter-pemasakan.index')
                ->with('success', 'Data parameter pemasakan berhasil disimpan.');
        } catch (Throwable $e) {
            DB::rollBack();
 
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
 
    public function edit($id)
    {
        $parameterPemasakan = ParameterPemasakan::with('productionBatch.product')->findOrFail($id);
 
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.parameter-pemasakan.edit', compact('parameterPemasakan', 'productionBatches'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'penggunaan_mesin' => ['nullable', 'string', 'max:255'],
            'drying_1_suhu' => ['nullable', 'numeric'],
            'drying_1_rh' => ['nullable', 'numeric'],
            'drying_1_waktu' => ['nullable', 'numeric'],
            'drying_2_suhu' => ['nullable', 'numeric'],
            'drying_2_rh' => ['nullable', 'numeric'],
            'drying_2_waktu' => ['nullable', 'numeric'],
            'drying_3_suhu' => ['nullable', 'numeric'],
            'drying_3_rh' => ['nullable', 'numeric'],
            'drying_3_waktu' => ['nullable', 'numeric'],
            'cooking_suhu' => ['nullable', 'numeric'],
            'cooking_rh' => ['nullable', 'numeric'],
            'cooking_waktu' => ['nullable', 'numeric'],
            'smoke_suhu' => ['nullable', 'numeric'],
            'smoke_rh' => ['nullable', 'numeric'],
            'smoke_waktu' => ['nullable', 'numeric'],
            'drying_4_suhu' => ['nullable', 'numeric'],
            'drying_4_rh' => ['nullable', 'numeric'],
            'drying_4_waktu' => ['nullable', 'numeric'],
            'suhu_produk_matang' => ['nullable', 'numeric'],
        ]);
 
        $parameterPemasakan = ParameterPemasakan::findOrFail($id);
 
        DB::beginTransaction();
 
        try {
            $parameterPemasakan->update([
                'production_batch_id' => $request->production_batch_id,
                'penggunaan_mesin' => $request->penggunaan_mesin,
                'drying_1_suhu' => $request->drying_1_suhu,
                'drying_1_rh' => $request->drying_1_rh,
                'drying_1_waktu' => $request->drying_1_waktu,
                'drying_2_suhu' => $request->drying_2_suhu,
                'drying_2_rh' => $request->drying_2_rh,
                'drying_2_waktu' => $request->drying_2_waktu,
                'drying_3_suhu' => $request->drying_3_suhu,
                'drying_3_rh' => $request->drying_3_rh,
                'drying_3_waktu' => $request->drying_3_waktu,
                'cooking_suhu' => $request->cooking_suhu,
                'cooking_rh' => $request->cooking_rh,
                'cooking_waktu' => $request->cooking_waktu,
                'smoke_suhu' => $request->smoke_suhu,
                'smoke_rh' => $request->smoke_rh,
                'smoke_waktu' => $request->smoke_waktu,
                'drying_4_suhu' => $request->drying_4_suhu,
                'drying_4_rh' => $request->drying_4_rh,
                'drying_4_waktu' => $request->drying_4_waktu,
                'suhu_produk_matang' => $request->suhu_produk_matang,
            ]);
 
            DB::commit();
 
            return redirect()
                ->route('operator.parameter-pemasakan.index')
                ->with('success', 'Data parameter pemasakan berhasil diperbarui.');
        } catch (Throwable $e) {
            DB::rollBack();
 
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
 
    public function destroy($id)
    {
        try {
            $parameterPemasakan = ParameterPemasakan::findOrFail($id);
            $parameterPemasakan->delete();
 
            return redirect()
                ->route('operator.parameter-pemasakan.index')
                ->with('success', 'Data parameter pemasakan berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.parameter-pemasakan.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
 
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:parameter_pemasakans,id',
            ],
        ]);
 
        ParameterPemasakan::whereIn('id', $request->ids)->delete();
 
        return redirect()
            ->route('operator.parameter-pemasakan.index')
            ->with('success', 'Data parameter pemasakan yang dipilih berhasil dihapus.');
    }
 
    public function managerIndex(Request $request)
    {
        $query = ParameterPemasakan::with('productionBatch.product')->latest();
 
        if ($request->filled('kode_batch')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
            });
        }
 
        if ($request->filled('date_from')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->whereDate('tanggal', '>=', $request->date_from);
            });
        }
 
        if ($request->filled('date_to')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->whereDate('tanggal', '<=', $request->date_to);
            });
        }
 
        if ($request->filled('shift')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->where('shift', $request->shift);
            });
        }
 
        $parameterPemasakans = $query->paginate(10)->withQueryString();
 
        return view('pages.manager.parameter-pemasakan.index', compact('parameterPemasakans'));
    }
 
    public function managerDetail($id)
    {
        $parameterPemasakan = ParameterPemasakan::with('productionBatch.product')->findOrFail($id);
 
        return view('pages.manager.parameter-pemasakan.detail', compact('parameterPemasakan'));
    }
}
