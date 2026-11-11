<?php

namespace App\Http\Controllers;

use App\Models\ProductionBatch;
use App\Models\SamplingPackingLuar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SamplingPackingLuarController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductionBatch::query()
            ->withCount('samplingPackingLuars')
            ->with('product');
 
        if ($request->filled('kode_batch')) {
            $query->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
        }
 
        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }
 
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }
 
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }
 
        $productionBatches = $query
            ->whereHas('samplingPackingLuars')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();
 
        return view('pages.operator.sampling-packing-luar.index', compact('productionBatches'));
    }
 
    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.sampling-packing-luar.create', compact('productionBatches'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'sampling' => ['nullable', 'array'],
            'sampling.*.sampling_ke' => ['required', 'integer', 'min:1'],
            'sampling.*.berat_per_bok' => ['nullable'],
            'sampling.*.range_berat' => ['nullable'],
            'sampling.*.standar_berat' => ['nullable'],
        ]);
 
        DB::beginTransaction();
 
        try {
            $hasSampling = false;
 
            foreach ($request->input('sampling', []) as $row) {
                $isFilled = collect($row)->contains(function ($value) {
                    return $value !== null && $value !== '';
                });
 
                if ($isFilled) {
                    SamplingPackingLuar::create([
                        'production_batch_id' => $request->production_batch_id,
                        'sampling_ke' => $row['sampling_ke'],
                        'berat_per_bok' => $row['berat_per_bok'] ?? null,
                        'range_berat' => $row['range_berat'] ?? null,
                        'standar_berat' => $row['standar_berat'] ?? null,
                    ]);
 
                    $hasSampling = true;
                }
            }
 
            if (!$hasSampling) {
                throw new \Exception('Minimal satu data sampling harus diisi.');
            }
 
            DB::commit();
 
            return redirect()
                ->route('operator.sampling-packing-luar.index')
                ->with('success', 'Sampling packing luar berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
 
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan sampling packing luar: ' . $e->getMessage());
        }
    }
 
    public function detail($productionBatchId)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);
 
        $samplingPackingLuars = SamplingPackingLuar::where('production_batch_id', $productionBatch->id)
            ->orderBy('sampling_ke')
            ->get();
 
        abort_if($samplingPackingLuars->isEmpty(), 404);
 
        return view(
            'pages.operator.sampling-packing-luar.detail',
            compact('productionBatch', 'samplingPackingLuars')
        );
    }
 
    public function edit($id)
    {
        $samplingPackingLuar = SamplingPackingLuar::findOrFail($id);
 
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view(
            'pages.operator.sampling-packing-luar.edit',
            compact('samplingPackingLuar', 'productionBatches')
        );
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'sampling_ke' => ['required', 'integer', 'min:1'],
            'berat_per_bok' => ['nullable'],
            'range_berat' => ['nullable'],
            'standar_berat' => ['nullable'],
        ]);
 
        $samplingPackingLuar = SamplingPackingLuar::findOrFail($id);
 
        $samplingPackingLuar->update($request->only([
            'production_batch_id',
            'sampling_ke',
            'berat_per_bok',
            'range_berat',
            'standar_berat',
        ]));
 
        return redirect()
            ->route('operator.sampling-packing-luar.detail', $samplingPackingLuar->production_batch_id)
            ->with('success', 'Sampling packing luar berhasil diperbarui.');
    }
 
    public function destroy($id)
    {
        try {
            $samplingPackingLuar = SamplingPackingLuar::findOrFail($id);
            $productionBatchId = $samplingPackingLuar->production_batch_id;
 
            $samplingPackingLuar->delete();
 
            $remaining = SamplingPackingLuar::where('production_batch_id', $productionBatchId)->count();
 
            return redirect()
                ->route(
                    $remaining > 0
                        ? 'operator.sampling-packing-luar.detail'
                        : 'operator.sampling-packing-luar.index',
                    $remaining > 0 ? $productionBatchId : []
                )
                ->with('success', 'Sampling packing luar berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus sampling packing luar: ' . $e->getMessage());
        }
    }
 
    public function managerIndex(Request $request)
    {
        $query = ProductionBatch::query()
            ->withCount('samplingPackingLuars')
            ->with('product');
 
        if ($request->filled('kode_batch')) {
            $query->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
        }
 
        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }
 
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }
 
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }
 
        $productionBatches = $query
            ->whereHas('samplingPackingLuars')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();
 
        return view('pages.manager.sampling-packing-luar.index', compact('productionBatches'));
    }
 
    public function managerDetail($productionBatchId)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);
 
        $samplingPackingLuars = SamplingPackingLuar::where('production_batch_id', $productionBatch->id)
            ->orderBy('sampling_ke')
            ->get();
 
        abort_if($samplingPackingLuars->isEmpty(), 404);
 
        return view(
            'pages.manager.sampling-packing-luar.detail',
            compact('productionBatch', 'samplingPackingLuars')
        );
    }
}
