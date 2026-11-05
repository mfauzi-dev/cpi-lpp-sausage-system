<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\ProductFormula;
use App\Models\ProductionBatch;
use App\Models\ProduksiBahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiBahanBakuController extends Controller
{
    public function getFormulas($productionBatchId)
    {
        $batch = ProductionBatch::findOrFail($productionBatchId);

        $formulas = ProductFormula::with('bahanBaku:id,name')
            ->where('product_id', $batch->product_id)
            ->orderBy('multiplier')
            ->get(['id', 'bahan_baku_id', 'multiplier', 'qty']);

        return response()->json($formulas);
    }

    public function index(Request $request)
    {
        $query = ProduksiBahanBaku::with('productionBatch.product')->withCount('items')->latest();

        if ($request->filled('kode_batch')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->whereDate('tanggal_produksi', '>=', $request->date_from);
            });
        }

        if ($request->filled('date_to')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->whereDate('tanggal_produksi', '<=', $request->date_to);
            });
        }

        if ($request->filled('shift')) {
            $query->whereHas('productionBatch', function ($q) use ($request) {
                $q->where('shift', $request->shift);
            });
        }

        $produksiBahanBakus = $query->paginate(10)->withQueryString();

        return view('pages.operator.produksi-bahan-baku.index', compact('produksiBahanBakus'));
    }

    public function create()
    {
        $bahanBakus = BahanBaku::orderBy('name')->get();

        return view('pages.operator.produksi-bahan-baku.create', compact('bahanBakus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => [
                'required',
                'exists:production_batches,id',
                'unique:produksi_bahan_bakus,production_batch_id',
            ],
            'penggunaan' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.bahan_baku_id' => ['required', 'exists:bahan_bakus,id'],
            'items.*.product_formula_id' => ['nullable', 'exists:product_formulas,id'],
            'items.*.kode_batch' => ['nullable', 'string', 'max:100'],
            'items.*.best_before' => ['nullable', 'date'],
            'items.*.total_kg' => ['nullable', 'numeric', 'min:0'],
            'items.*.suhu_rm' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $produksi = ProduksiBahanBaku::create([
                'production_batch_id' => $request->production_batch_id,
            ]);

            $hasItem = false;

            foreach ($request->items as $row) {
                $isFilled = !empty($row['kode_batch'])
                    || !empty($row['best_before'])
                    || !empty($row['total_kg'])
                    || !empty($row['suhu_rm']);

                if ($isFilled) {
                    $produksi->items()->create([
                        'bahan_baku_id' => $row['bahan_baku_id'],
                        'product_formula_id' => $row['product_formula_id'] ?? null,
                        'kode_batch' => $row['kode_batch'] ?? null,
                        'best_before' => $row['best_before'] ?? null,
                        'total_kg' => $row['total_kg'] ?? 0,
                        'suhu_rm' => $row['suhu_rm'] ?? null,
                    ]);

                    $hasItem = true;
                }
            }

            if (!$hasItem) {
                throw new \Exception('Minimal satu bahan baku harus diisi datanya.');
            }

            $penggunaan = (float) $request->penggunaan;
            $total = (float) $produksi->items()->sum('total_kg');

            if ($penggunaan > $total) {
                throw new \Exception('Penggunaan tidak boleh melebihi total bahan baku.');
            }

            $produksi->update([
                'total' => $total,
                'penggunaan' => $penggunaan,
                'sisa' => $total - $penggunaan,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.produksi-bahan-baku.index')
                ->with('success', 'Data bahan baku produksi berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function detail($id)
    {
        $produksi = ProduksiBahanBaku::with(['productionBatch.product.formulas', 'items.bahanBaku', 'items.productFormula'])
                        ->findOrFail($id);

        return view(
            'pages.operator.produksi-bahan-baku.detail',
            compact('produksi')
        );
    }

    public function edit($id)
    {
        $produksi = ProduksiBahanBaku::with(['productionBatch.product', 'items.bahanBaku','items.productFormula'])
                        ->findOrFail($id);

        $bahanBakus = BahanBaku::orderBy('name')->get();

        $formulas = ProductFormula::with('bahanBaku:id,name')
            ->where('product_id', $produksi->productionBatch->product_id)
            ->orderBy('multiplier')
            ->get();

        return view(
            'pages.operator.produksi-bahan-baku.edit',
            compact('produksi', 'bahanBakus', 'formulas')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => [
                'required',
                'exists:production_batches,id',
            ],
            'penggunaan' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.bahan_baku_id' => ['required', 'exists:bahan_bakus,id'],
            'items.*.product_formula_id' => ['nullable', 'exists:product_formulas,id'],
            'items.*.kode_batch' => ['nullable', 'string', 'max:100'],
            'items.*.best_before' => ['nullable', 'date'],
            'items.*.total_kg' => ['nullable', 'numeric', 'min:0'],
            'items.*.suhu_rm' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $produksi = ProduksiBahanBaku::findOrFail($id);

            $produksi->update([
                'production_batch_id' => $request->production_batch_id,
            ]);

            $produksi->items()->delete();

            $hasItem = false;

            foreach ($request->items as $row) {
                $isFilled = !empty($row['kode_batch'])
                    || !empty($row['best_before'])
                    || !empty($row['total_kg'])
                    || !empty($row['suhu_rm']);

                if ($isFilled) {
                    $produksi->items()->create([
                        'bahan_baku_id' => $row['bahan_baku_id'],
                        'product_formula_id' => $row['product_formula_id'] ?? null,
                        'kode_batch' => $row['kode_batch'] ?? null,
                        'best_before' => $row['best_before'] ?? null,
                        'total_kg' => $row['total_kg'] ?? 0,
                        'suhu_rm' => $row['suhu_rm'] ?? null,
                    ]);

                    $hasItem = true;
                }
            }

            if (!$hasItem) {
                throw new \Exception('Minimal satu bahan baku harus diisi datanya.');
            }

            $penggunaan = (float) $request->penggunaan;
            $total = (float) $produksi->items()->sum('total_kg');

            if ($penggunaan > $total) {
                throw new \Exception('Penggunaan tidak boleh melebihi total bahan baku.');
            }

            $produksi->update([
                'total' => $total,
                'penggunaan' => $penggunaan,
                'sisa' => $total - $penggunaan,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.produksi-bahan-baku.detail', $produksi->id)
                ->with('success', 'Data bahan baku produksi berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            ProduksiBahanBaku::findOrFail($id)->delete();

            return redirect()
                ->route('operator.produksi-bahan-baku.index')
                ->with('success', 'Data bahan baku produksi berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('operator.produksi-bahan-baku.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function managerIndex(Request $request)
    {
        $query = ProduksiBahanBaku::with('productionBatch.product')->withCount('items')->latest();

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

        $produksiBahanBakus = $query->paginate(10)->withQueryString();

        return view(
            'pages.manager.produksi-bahan-baku.index',
            compact('produksiBahanBakus')
        );
    }

    public function managerDetail($id)
    {
        $produksi = ProduksiBahanBaku::with(['productionBatch.product', 'items.bahanBaku', 'items.productFormula'])
                        ->findOrFail($id);

        return view(
            'pages.manager.produksi-bahan-baku.detail',
            compact('produksi')
        );
    }

    public function bulkDestroyItems(Request $request)
    {
        $request->validate([
            'produksi_bahan_baku_id' => ['required', 'integer', 'exists:produksi_bahan_bakus,id'],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:produksi_bahan_baku_items,id'],
        ]);

        DB::beginTransaction();

        try {
            $produksi = ProduksiBahanBaku::findOrFail($request->produksi_bahan_baku_id);

            $deleted = $produksi->items()
                ->whereIn('id', $request->ids)
                ->delete();

            $remaining = $produksi->items()->count();

            if ($remaining === 0) {
                $produksi->delete();

                DB::commit();

                return redirect()
                    ->route('operator.produksi-bahan-baku.index')
                    ->with('success', $deleted . ' item bahan baku berhasil dihapus. Data produksi bahan baku ikut terhapus karena sudah tidak ada item tersisa.');
            }

            $total = (float) $produksi->items()->sum('total_kg');
            $penggunaan = (float) $produksi->penggunaan;

            if ($penggunaan > $total) {
                $penggunaan = $total;
            }

            $produksi->update([
                'total' => $total,
                'penggunaan' => $penggunaan,
                'sisa' => $total - $penggunaan,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.produksi-bahan-baku.detail', $produksi->id)
                ->with('success', $deleted . ' item bahan baku berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus item: ' . $e->getMessage());
        }
    }
}
