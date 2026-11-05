<?php

namespace App\Http\Controllers;

use App\Models\ProductionBatch;
use App\Models\SuhuArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuhuAreaController extends Controller
{
    public function index(Request $request)
    {
        $query = SuhuArea::with('productionBatch.product')->latest();
 
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
 
        $suhuAreas = $query->paginate(10)->withQueryString();
 
        return view('pages.operator.suhu-area.index', compact('suhuAreas'));
    }
 
    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.suhu-area.create', compact('productionBatches'));
    }
 
    public function detail($id)
    {
        $suhuArea = SuhuArea::with('productionBatch.product')->findOrFail($id);
 
        return view('pages.operator.suhu-area.detail', compact('suhuArea'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'chillroom_std' => ['nullable', 'numeric'],
            'chillroom_act' => ['nullable', 'numeric'],
            'meatprep_std' => ['nullable', 'numeric'],
            'meatprep_act' => ['nullable', 'numeric'],
            'cooking_std' => ['nullable', 'numeric'],
            'cooking_act' => ['nullable', 'numeric'],
            'seasoning_std' => ['nullable', 'numeric'],
            'seasoning_act' => ['nullable', 'numeric'],
            'cooling_down_std' => ['nullable', 'numeric'],
            'cooling_down_act' => ['nullable', 'numeric'],
            'packing_dalam_std' => ['nullable', 'numeric'],
            'packing_dalam_act' => ['nullable', 'numeric'],
            'packing_luar_std' => ['nullable', 'numeric'],
            'packing_luar_act' => ['nullable', 'numeric'],
        ]);
 
        DB::beginTransaction();
 
        try {
            SuhuArea::create([
                'production_batch_id' => $request->production_batch_id,
                'chillroom_std' => $request->chillroom_std,
                'chillroom_act' => $request->chillroom_act,
                'meatprep_std' => $request->meatprep_std,
                'meatprep_act' => $request->meatprep_act,
                'cooking_std' => $request->cooking_std,
                'cooking_act' => $request->cooking_act,
                'seasoning_std' => $request->seasoning_std,
                'seasoning_act' => $request->seasoning_act,
                'cooling_down_std' => $request->cooling_down_std,
                'cooling_down_act' => $request->cooling_down_act,
                'packing_dalam_std' => $request->packing_dalam_std,
                'packing_dalam_act' => $request->packing_dalam_act,
                'packing_luar_std' => $request->packing_luar_std,
                'packing_luar_act' => $request->packing_luar_act,
            ]);
 
            DB::commit();
 
            return redirect()
                ->route('operator.suhu-area.index')
                ->with('success', 'Data suhu area berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
 
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
 
    public function edit($id)
    {
        $suhuArea = SuhuArea::with('productionBatch.product')->findOrFail($id);
 
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.suhu-area.edit', compact('suhuArea', 'productionBatches'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'chillroom_std' => ['nullable', 'numeric'],
            'chillroom_act' => ['nullable', 'numeric'],
            'meatprep_std' => ['nullable', 'numeric'],
            'meatprep_act' => ['nullable', 'numeric'],
            'cooking_std' => ['nullable', 'numeric'],
            'cooking_act' => ['nullable', 'numeric'],
            'seasoning_std' => ['nullable', 'numeric'],
            'seasoning_act' => ['nullable', 'numeric'],
            'cooling_down_std' => ['nullable', 'numeric'],
            'cooling_down_act' => ['nullable', 'numeric'],
            'packing_dalam_std' => ['nullable', 'numeric'],
            'packing_dalam_act' => ['nullable', 'numeric'],
            'packing_luar_std' => ['nullable', 'numeric'],
            'packing_luar_act' => ['nullable', 'numeric'],
        ]);
 
        $suhuArea = SuhuArea::findOrFail($id);
 
        DB::beginTransaction();
 
        try {
            $suhuArea->update([
                'production_batch_id' => $request->production_batch_id,
                'chillroom_std' => $request->chillroom_std,
                'chillroom_act' => $request->chillroom_act,
                'meatprep_std' => $request->meatprep_std,
                'meatprep_act' => $request->meatprep_act,
                'cooking_std' => $request->cooking_std,
                'cooking_act' => $request->cooking_act,
                'seasoning_std' => $request->seasoning_std,
                'seasoning_act' => $request->seasoning_act,
                'cooling_down_std' => $request->cooling_down_std,
                'cooling_down_act' => $request->cooling_down_act,
                'packing_dalam_std' => $request->packing_dalam_std,
                'packing_dalam_act' => $request->packing_dalam_act,
                'packing_luar_std' => $request->packing_luar_std,
                'packing_luar_act' => $request->packing_luar_act,
            ]);
 
            DB::commit();
 
            return redirect()
                ->route('operator.suhu-area.index')
                ->with('success', 'Data suhu area berhasil diperbarui.');
        } catch (\Throwable $e) {
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
            $suhuArea = SuhuArea::findOrFail($id);
            $suhuArea->delete();
 
            return redirect()
                ->route('operator.suhu-area.index')
                ->with('success', 'Data suhu area berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('operator.suhu-area.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
 
    public function managerIndex(Request $request)
    {
        $query = SuhuArea::with('productionBatch.product')->latest();
 
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
 
        $suhuAreas = $query->paginate(10)->withQueryString();
 
        return view('pages.manager.suhu-area.index', compact('suhuAreas'));
    }
 
    public function managerDetail($id)
    {
        $suhuArea = SuhuArea::with('productionBatch.product')->findOrFail($id);
 
        return view('pages.manager.suhu-area.detail', compact('suhuArea'));
    }
}
