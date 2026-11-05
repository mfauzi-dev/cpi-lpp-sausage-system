<?php

namespace App\Http\Controllers;

use App\Models\KartonBoxPackingLuar;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class KartonBoxPackingLuarController extends Controller
{
    public function index(Request $request)
    {
        $query = KartonBoxPackingLuar::select('production_batch_id')
            ->selectRaw('COUNT(*) as items_count')
            ->selectRaw('MAX(id) as last_id')
            ->with('productionBatch.product')
            ->groupBy('production_batch_id')
            ->orderByDesc('last_id');

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

        $kartonBoxPackingLuars = $query->paginate(10)->withQueryString();

        return view('pages.operator.karton-box-packing-luar.index', compact('kartonBoxPackingLuars'));
    }

    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.karton-box-packing-luar.create', compact('productionBatches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => [
                'required',
                'exists:production_batches,id',
                'unique:karton_box_packing_luars,production_batch_id',
            ],
            'items' => ['required', 'array', 'min:1'],
            'items.*.jenis_karton_box' => ['nullable', 'string', 'max:255'],
            'items.*.qty_box' => ['nullable', 'numeric', 'min:0'],
            'items.*.pemakaian' => ['nullable', 'numeric', 'min:0'],
            'items.*.sisa' => ['nullable', 'numeric', 'min:0'],
            'items.*.reject' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();

        try {
            $hasItem = false;

            foreach ($request->items as $row) {
                $isFilled = !empty($row['jenis_karton_box'])
                    || !empty($row['qty_box'])
                    || !empty($row['pemakaian'])
                    || !empty($row['sisa'])
                    || !empty($row['reject']);

                if ($isFilled) {
                    KartonBoxPackingLuar::create([
                        'production_batch_id' => $request->production_batch_id,
                        'jenis_karton_box' => $row['jenis_karton_box'] ?? null,
                        'qty_box' => $row['qty_box'] ?? null,
                        'pemakaian' => $row['pemakaian'] ?? null,
                        'sisa' => $row['sisa'] ?? null,
                        'reject' => $row['reject'] ?? null,
                    ]);

                    $hasItem = true;
                }
            }

            if (!$hasItem) {
                throw new \Exception('Minimal satu baris jenis karton box harus diisi datanya.');
            }

            DB::commit();

            return redirect()
                ->route('operator.karton-box-packing-luar.index')
                ->with('success', 'Data karton box packing luar berhasil disimpan.');
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function detail($productionBatchId)
    {
        $rows = KartonBoxPackingLuar::with('productionBatch.product')
            ->where('production_batch_id', $productionBatchId)
            ->orderBy('id')
            ->get();

        if ($rows->isEmpty()) {
            abort(404);
        }

        $productionBatch = $rows->first()->productionBatch;

        return view(
            'pages.operator.karton-box-packing-luar.detail',
            compact('rows', 'productionBatch')
        );
    }

    public function edit($productionBatchId)
    {
        $rows = KartonBoxPackingLuar::where('production_batch_id', $productionBatchId)
            ->orderBy('id')
            ->get();

        if ($rows->isEmpty()) {
            abort(404);
        }

        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);

        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view(
            'pages.operator.karton-box-packing-luar.edit',
            compact('rows', 'productionBatch', 'productionBatches')
        );
    }

    public function update(Request $request, $productionBatchId)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.jenis_karton_box' => ['nullable', 'string', 'max:255'],
            'items.*.qty_box' => ['nullable', 'numeric', 'min:0'],
            'items.*.pemakaian' => ['nullable', 'numeric', 'min:0'],
            'items.*.sisa' => ['nullable', 'numeric', 'min:0'],
            'items.*.reject' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();

        try {
            $newBatchId = $request->production_batch_id;

            if ((int) $newBatchId !== (int) $productionBatchId) {
                $exists = KartonBoxPackingLuar::where('production_batch_id', $newBatchId)->exists();

                if ($exists) {
                    throw new \Exception('Production batch tujuan sudah memiliki data karton box packing luar.');
                }
            }

            KartonBoxPackingLuar::where('production_batch_id', $productionBatchId)->delete();

            $hasItem = false;

            foreach ($request->items as $row) {
                $isFilled = !empty($row['jenis_karton_box'])
                    || !empty($row['qty_box'])
                    || !empty($row['pemakaian'])
                    || !empty($row['sisa'])
                    || !empty($row['reject']);

                if ($isFilled) {
                    KartonBoxPackingLuar::create([
                        'production_batch_id' => $newBatchId,
                        'jenis_karton_box' => $row['jenis_karton_box'] ?? null,
                        'qty_box' => $row['qty_box'] ?? null,
                        'pemakaian' => $row['pemakaian'] ?? null,
                        'sisa' => $row['sisa'] ?? null,
                        'reject' => $row['reject'] ?? null,
                    ]);

                    $hasItem = true;
                }
            }

            if (!$hasItem) {
                throw new \Exception('Minimal satu baris jenis karton box harus diisi datanya.');
            }

            DB::commit();

            return redirect()
                ->route('operator.karton-box-packing-luar.detail', $newBatchId)
                ->with('success', 'Data karton box packing luar berhasil diperbarui.');
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($productionBatchId)
    {
        try {
            KartonBoxPackingLuar::where('production_batch_id', $productionBatchId)->delete();

            return redirect()
                ->route('operator.karton-box-packing-luar.index')
                ->with('success', 'Data karton box packing luar berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.karton-box-packing-luar.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function bulkDestroyItems(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'integer', 'exists:production_batches,id'],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:karton_box_packing_luars,id'],
        ]);

        DB::beginTransaction();

        try {
            $deleted = KartonBoxPackingLuar::where('production_batch_id', $request->production_batch_id)
                ->whereIn('id', $request->ids)
                ->delete();

            $remaining = KartonBoxPackingLuar::where('production_batch_id', $request->production_batch_id)->count();

            DB::commit();

            if ($remaining === 0) {
                return redirect()
                    ->route('operator.karton-box-packing-luar.index')
                    ->with('success', $deleted . ' baris berhasil dihapus. Data ikut terhapus karena sudah tidak ada baris tersisa.');
            }

            return redirect()
                ->route('operator.karton-box-packing-luar.detail', $request->production_batch_id)
                ->with('success', $deleted . ' baris berhasil dihapus.');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus baris: ' . $e->getMessage());
        }
    }

    public function managerIndex(Request $request)
    {
        $query = KartonBoxPackingLuar::select('production_batch_id')
            ->selectRaw('COUNT(*) as items_count')
            ->selectRaw('MAX(id) as last_id')
            ->with('productionBatch.product')
            ->groupBy('production_batch_id')
            ->orderByDesc('last_id');

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

        $kartonBoxPackingLuars = $query->paginate(10)->withQueryString();

        return view('pages.manager.karton-box-packing-luar.index', compact('kartonBoxPackingLuars'));
    }

    public function managerDetail($productionBatchId)
    {
        $rows = KartonBoxPackingLuar::with('productionBatch.product')
            ->where('production_batch_id', $productionBatchId)
            ->orderBy('id')
            ->get();

        if ($rows->isEmpty()) {
            abort(404);
        }

        $productionBatch = $rows->first()->productionBatch;

        return view(
            'pages.manager.karton-box-packing-luar.detail',
            compact('rows', 'productionBatch')
        );
    }
}
