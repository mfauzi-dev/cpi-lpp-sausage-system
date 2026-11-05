<?php

namespace App\Http\Controllers;

use App\Models\ProductionBatch;
use App\Models\SamplingPackingDalam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SamplingPackingDalamController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductionBatch::query()
            ->withCount('samplingPackingDalams')
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
            ->whereHas('samplingPackingDalams')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.operator.sampling-packing-dalam.index', compact('productionBatches'));
    }

    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.sampling-packing-dalam.create', compact('productionBatches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'sampling' => ['nullable', 'array'],
            'sampling.*.sampling_ke' => ['required', 'integer', 'min:1'],
            'sampling.*.berat_kemasan' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.berat_per_bag' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.range_berat' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.standar_berat' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();

        try {
            $hasSampling = false;

            foreach ($request->input('sampling', []) as $row) {
                $isFilled = collect($row)->contains(function ($value) {
                    return $value !== null && $value !== '';
                });

                if ($isFilled) {
                    SamplingPackingDalam::create([
                        'production_batch_id' => $request->production_batch_id,
                        'sampling_ke' => $row['sampling_ke'],
                        'berat_kemasan' => $row['berat_kemasan'] ?? null,
                        'berat_per_bag' => $row['berat_per_bag'] ?? null,
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
                ->route('operator.sampling-packing-dalam.index')
                ->with('success', 'Sampling packing dalam berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan sampling packing dalam: ' . $e->getMessage());
        }
    }

    public function detail($productionBatchId)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);

        $samplingPackingDalams = SamplingPackingDalam::where('production_batch_id', $productionBatch->id)
            ->orderBy('sampling_ke')
            ->get();

        abort_if($samplingPackingDalams->isEmpty(), 404);

        return view(
            'pages.operator.sampling-packing-dalam.detail',
            compact('productionBatch', 'samplingPackingDalams')
        );
    }

    public function edit($id)
    {
        $samplingPackingDalam = SamplingPackingDalam::findOrFail($id);

        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view(
            'pages.operator.sampling-packing-dalam.edit',
            compact('samplingPackingDalam', 'productionBatches')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'sampling_ke' => ['required', 'integer', 'min:1'],
            'berat_kemasan' => ['nullable', 'numeric', 'min:0'],
            'berat_per_bag' => ['nullable', 'numeric', 'min:0'],
            'range_berat' => ['nullable', 'numeric', 'min:0'],
            'standar_berat' => ['nullable', 'numeric', 'min:0'],
        ]);

        $samplingPackingDalam = SamplingPackingDalam::findOrFail($id);

        $samplingPackingDalam->update($request->only([
            'production_batch_id',
            'sampling_ke',
            'berat_kemasan',
            'berat_per_bag',
            'range_berat',
            'standar_berat',
        ]));

        return redirect()
            ->route('operator.sampling-packing-dalam.detail', $samplingPackingDalam->production_batch_id)
            ->with('success', 'Sampling packing dalam berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $samplingPackingDalam = SamplingPackingDalam::findOrFail($id);
            $productionBatchId = $samplingPackingDalam->production_batch_id;

            $samplingPackingDalam->delete();

            $remaining = SamplingPackingDalam::where('production_batch_id', $productionBatchId)->count();

            return redirect()
                ->route(
                    $remaining > 0
                        ? 'operator.sampling-packing-dalam.detail'
                        : 'operator.sampling-packing-dalam.index',
                    $remaining > 0 ? $productionBatchId : []
                )
                ->with('success', 'Sampling packing dalam berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus sampling packing dalam: ' . $e->getMessage());
        }
    }

    public function managerIndex(Request $request)
    {
        $query = ProductionBatch::query()
            ->withCount('samplingPackingDalams')
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
            ->whereHas('samplingPackingDalams')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.manager.sampling-packing-dalam.index', compact('productionBatches'));
    }

    public function managerDetail($productionBatchId)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);

        $samplingPackingDalams = SamplingPackingDalam::where('production_batch_id', $productionBatch->id)
            ->orderBy('sampling_ke')
            ->get();

        abort_if($samplingPackingDalams->isEmpty(), 404);

        return view(
            'pages.manager.sampling-packing-dalam.detail',
            compact('productionBatch', 'samplingPackingDalams')
        );
    }
}
