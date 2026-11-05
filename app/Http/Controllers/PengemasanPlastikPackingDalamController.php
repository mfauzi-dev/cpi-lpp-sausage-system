<?php

namespace App\Http\Controllers;

use App\Models\PengemasanPlastikPackingDalam;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PengemasanPlastikPackingDalamController extends Controller
{
    public function index(Request $request)
    {
        $query = PengemasanPlastikPackingDalam::select('production_batch_id')
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
 
        $pengemasanPlastikPackingDalams = $query->paginate(10)->withQueryString();
 
        return view('pages.operator.pengemasan-plastik-packing-dalam.index', compact('pengemasanPlastikPackingDalams'));
    }
 
    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.pengemasan-plastik-packing-dalam.create', compact('productionBatches'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => [
                'required',
                'exists:production_batches,id',
                'unique:pengemasan_plastik_packing_dalams,production_batch_id',
            ],
            'items' => ['required', 'array', 'min:1'],
            'items.*.jenis_plastik' => ['nullable', 'string', 'max:255'],
            'items.*.no_md' => ['nullable', 'string', 'max:255'],
            'items.*.qty_pack' => ['nullable', 'integer', 'min:0'],
            'items.*.pemakaian' => ['nullable', 'numeric', 'min:0'],
            'items.*.sisa' => ['nullable', 'numeric', 'min:0'],
            'items.*.reject_plastik' => ['nullable', 'numeric', 'min:0'],
        ]);
 
        DB::beginTransaction();
 
        try {
            $hasItem = false;
 
            foreach ($request->items as $row) {
                $isFilled = !empty($row['jenis_plastik'])
                    || !empty($row['no_md'])
                    || !empty($row['qty_pack'])
                    || !empty($row['pemakaian'])
                    || !empty($row['sisa'])
                    || !empty($row['reject_plastik']);
 
                if ($isFilled) {
                    PengemasanPlastikPackingDalam::create([
                        'production_batch_id' => $request->production_batch_id,
                        'jenis_plastik' => $row['jenis_plastik'] ?? null,
                        'no_md' => $row['no_md'] ?? null,
                        'qty_pack' => $row['qty_pack'] ?? null,
                        'pemakaian' => $row['pemakaian'] ?? null,
                        'sisa' => $row['sisa'] ?? null,
                        'reject_plastik' => $row['reject_plastik'] ?? null,
                    ]);
 
                    $hasItem = true;
                }
            }
 
            if (!$hasItem) {
                throw new \Exception('Minimal satu baris jenis plastik harus diisi datanya.');
            }
 
            DB::commit();
 
            return redirect()
                ->route('operator.pengemasan-plastik-packing-dalam.index')
                ->with('success', 'Data pengemasan plastik packing dalam berhasil disimpan.');
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
        $rows = PengemasanPlastikPackingDalam::with('productionBatch.product')
            ->where('production_batch_id', $productionBatchId)
            ->orderBy('id')
            ->get();
 
        if ($rows->isEmpty()) {
            abort(404);
        }
 
        $productionBatch = $rows->first()->productionBatch;
 
        return view(
            'pages.operator.pengemasan-plastik-packing-dalam.detail',
            compact('rows', 'productionBatch')
        );
    }
 
    public function edit($productionBatchId)
    {
        $rows = PengemasanPlastikPackingDalam::where('production_batch_id', $productionBatchId)
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
            'pages.operator.pengemasan-plastik-packing-dalam.edit',
            compact('rows', 'productionBatch', 'productionBatches')
        );
    }
 
    public function update(Request $request, $productionBatchId)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.jenis_plastik' => ['nullable', 'string', 'max:255'],
            'items.*.no_md' => ['nullable', 'string', 'max:255'],
            'items.*.qty_pack' => ['nullable', 'integer', 'min:0'],
            'items.*.pemakaian' => ['nullable', 'numeric', 'min:0'],
            'items.*.sisa' => ['nullable', 'numeric', 'min:0'],
            'items.*.reject_plastik' => ['nullable', 'numeric', 'min:0'],
        ]);
 
        DB::beginTransaction();
 
        try {
            $newBatchId = $request->production_batch_id;
 
            if ((int) $newBatchId !== (int) $productionBatchId) {
                $exists = PengemasanPlastikPackingDalam::where('production_batch_id', $newBatchId)->exists();
 
                if ($exists) {
                    throw new \Exception('Production batch tujuan sudah memiliki data pengemasan plastik packing dalam.');
                }
            }
 
            PengemasanPlastikPackingDalam::where('production_batch_id', $productionBatchId)->delete();
 
            $hasItem = false;
 
            foreach ($request->items as $row) {
                $isFilled = !empty($row['jenis_plastik'])
                    || !empty($row['no_md'])
                    || !empty($row['qty_pack'])
                    || !empty($row['pemakaian'])
                    || !empty($row['sisa'])
                    || !empty($row['reject_plastik']);
 
                if ($isFilled) {
                    PengemasanPlastikPackingDalam::create([
                        'production_batch_id' => $newBatchId,
                        'jenis_plastik' => $row['jenis_plastik'] ?? null,
                        'no_md' => $row['no_md'] ?? null,
                        'qty_pack' => $row['qty_pack'] ?? null,
                        'pemakaian' => $row['pemakaian'] ?? null,
                        'sisa' => $row['sisa'] ?? null,
                        'reject_plastik' => $row['reject_plastik'] ?? null,
                    ]);
 
                    $hasItem = true;
                }
            }
 
            if (!$hasItem) {
                throw new \Exception('Minimal satu baris jenis plastik harus diisi datanya.');
            }
 
            DB::commit();
 
            return redirect()
                ->route('operator.pengemasan-plastik-packing-dalam.detail', $newBatchId)
                ->with('success', 'Data pengemasan plastik packing dalam berhasil diperbarui.');
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
            PengemasanPlastikPackingDalam::where('production_batch_id', $productionBatchId)->delete();
 
            return redirect()
                ->route('operator.pengemasan-plastik-packing-dalam.index')
                ->with('success', 'Data pengemasan plastik packing dalam berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.pengemasan-plastik-packing-dalam.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
 
    public function bulkDestroyItems(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'integer', 'exists:production_batches,id'],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:pengemasan_plastik_packing_dalams,id'],
        ]);
 
        DB::beginTransaction();
 
        try {
            $deleted = PengemasanPlastikPackingDalam::where('production_batch_id', $request->production_batch_id)
                ->whereIn('id', $request->ids)
                ->delete();
 
            $remaining = PengemasanPlastikPackingDalam::where('production_batch_id', $request->production_batch_id)->count();
 
            DB::commit();
 
            if ($remaining === 0) {
                return redirect()
                    ->route('operator.pengemasan-plastik-packing-dalam.index')
                    ->with('success', $deleted . ' baris berhasil dihapus. Data ikut terhapus karena sudah tidak ada baris tersisa.');
            }
 
            return redirect()
                ->route('operator.pengemasan-plastik-packing-dalam.detail', $request->production_batch_id)
                ->with('success', $deleted . ' baris berhasil dihapus.');
        } catch (Throwable $e) {
            DB::rollBack();
 
            return back()->with('error', 'Gagal menghapus baris: ' . $e->getMessage());
        }
    }
 
    public function managerIndex(Request $request)
    {
        $query = PengemasanPlastikPackingDalam::select('production_batch_id')
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
 
        $pengemasanPlastikPackingDalams = $query->paginate(10)->withQueryString();
 
        return view('pages.manager.pengemasan-plastik-packing-dalam.index', compact('pengemasanPlastikPackingDalams'));
    }
 
    public function managerDetail($productionBatchId)
    {
        $rows = PengemasanPlastikPackingDalam::with('productionBatch.product')
            ->where('production_batch_id', $productionBatchId)
            ->orderBy('id')
            ->get();
 
        if ($rows->isEmpty()) {
            abort(404);
        }
 
        $productionBatch = $rows->first()->productionBatch;
 
        return view(
            'pages.manager.pengemasan-plastik-packing-dalam.detail',
            compact('rows', 'productionBatch')
        );
    }
}
