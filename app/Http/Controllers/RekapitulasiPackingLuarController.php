<?php

namespace App\Http\Controllers;

use App\Models\ProductionBatch;
use App\Models\RekapitulasiPackingLuar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RekapitulasiPackingLuarController extends Controller
{
    public function index(Request $request)
    {
        $query = RekapitulasiPackingLuar::with('productionBatch.product')->latest();
 
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
 
        $rekapitulasiPackingLuars = $query->paginate(10)->withQueryString();
 
        return view('pages.operator.rekapitulasi-packing-luar.index', compact('rekapitulasiPackingLuars'));
    }
 
    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.rekapitulasi-packing-luar.create', compact('productionBatches'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => [
                'required',
                'exists:production_batches,id',
                'unique:rekapitulasi_packing_luars,production_batch_id',
            ],
            'jumlah_batch' => ['nullable', 'integer', 'min:0'],
            'jumlah_pack' => ['nullable', 'numeric', 'min:0'],
            'jumlah_boks' => ['nullable', 'numeric', 'min:0'],
            'jumlah_kg' => ['nullable', 'numeric', 'min:0'],
            'no_bstb' => ['nullable', 'string', 'max:255'],
            'jumlah_wip_keluar_bag' => ['nullable', 'numeric', 'min:0'],
            'jumlah_wip_keluar_kg' => ['nullable', 'numeric', 'min:0'],
            'tanggal_transfer' => ['nullable', 'date'],
            'wip_masuk' => ['nullable', 'string', 'max:255'],
            'jumlah_wip_masuk' => ['nullable', 'numeric', 'min:0'],
            'checker' => ['nullable', 'string', 'max:255'],
            'kr' => ['nullable', 'string', 'max:255'],
        ]);
 
        DB::beginTransaction();
 
        try {
            RekapitulasiPackingLuar::create([
                'production_batch_id' => $request->production_batch_id,
                'jumlah_batch' => $request->jumlah_batch,
                'jumlah_pack' => $request->jumlah_pack,
                'jumlah_boks' => $request->jumlah_boks,
                'jumlah_kg' => $request->jumlah_kg,
                'no_bstb' => $request->no_bstb,
                'jumlah_wip_keluar_bag' => $request->jumlah_wip_keluar_bag,
                'jumlah_wip_keluar_kg' => $request->jumlah_wip_keluar_kg,
                'tanggal_transfer' => $request->tanggal_transfer,
                'wip_masuk' => $request->wip_masuk,
                'jumlah_wip_masuk' => $request->jumlah_wip_masuk,
                'checker' => $request->checker,
                'kr' => $request->kr,
            ]);
 
            DB::commit();
 
            return redirect()
                ->route('operator.rekapitulasi-packing-luar.index')
                ->with('success', 'Data rekapitulasi packing luar berhasil disimpan.');
        } catch (Throwable $e) {
            DB::rollBack();
 
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
 
    public function detail($id)
    {
        $rekapitulasiPackingLuar = RekapitulasiPackingLuar::with('productionBatch.product')->findOrFail($id);
 
        return view('pages.operator.rekapitulasi-packing-luar.detail', compact('rekapitulasiPackingLuar'));
    }
 
    public function edit($id)
    {
        $rekapitulasiPackingLuar = RekapitulasiPackingLuar::with('productionBatch.product')->findOrFail($id);
 
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.rekapitulasi-packing-luar.edit', compact('rekapitulasiPackingLuar', 'productionBatches'));
    }
 
    public function update(Request $request, $id)
    {
        $rekapitulasiPackingLuar = RekapitulasiPackingLuar::findOrFail($id);
 
        $request->validate([
            'production_batch_id' => [
                'required',
                'exists:production_batches,id',
                'unique:rekapitulasi_packing_luars,production_batch_id,' . $rekapitulasiPackingLuar->id,
            ],
            'jumlah_batch' => ['nullable', 'integer', 'min:0'],
            'jumlah_pack' => ['nullable', 'numeric', 'min:0'],
            'jumlah_boks' => ['nullable', 'numeric', 'min:0'],
            'jumlah_kg' => ['nullable', 'numeric', 'min:0'],
            'no_bstb' => ['nullable', 'string', 'max:255'],
            'jumlah_wip_keluar_bag' => ['nullable', 'numeric', 'min:0'],
            'jumlah_wip_keluar_kg' => ['nullable', 'numeric', 'min:0'],
            'tanggal_transfer' => ['nullable', 'date'],
            'wip_masuk' => ['nullable', 'string', 'max:255'],
            'jumlah_wip_masuk' => ['nullable', 'numeric', 'min:0'],
            'checker' => ['nullable', 'string', 'max:255'],
            'kr' => ['nullable', 'string', 'max:255'],
        ]);
 
        DB::beginTransaction();
 
        try {
            $rekapitulasiPackingLuar->update([
                'production_batch_id' => $request->production_batch_id,
                'jumlah_batch' => $request->jumlah_batch,
                'jumlah_pack' => $request->jumlah_pack,
                'jumlah_boks' => $request->jumlah_boks,
                'jumlah_kg' => $request->jumlah_kg,
                'no_bstb' => $request->no_bstb,
                'jumlah_wip_keluar_bag' => $request->jumlah_wip_keluar_bag,
                'jumlah_wip_keluar_kg' => $request->jumlah_wip_keluar_kg,
                'tanggal_transfer' => $request->tanggal_transfer,
                'wip_masuk' => $request->wip_masuk,
                'jumlah_wip_masuk' => $request->jumlah_wip_masuk,
                'checker' => $request->checker,
                'kr' => $request->kr,
            ]);
 
            DB::commit();
 
            return redirect()
                ->route('operator.rekapitulasi-packing-luar.index')
                ->with('success', 'Data rekapitulasi packing luar berhasil diperbarui.');
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
            $rekapitulasiPackingLuar = RekapitulasiPackingLuar::findOrFail($id);
            $rekapitulasiPackingLuar->delete();
 
            return redirect()
                ->route('operator.rekapitulasi-packing-luar.index')
                ->with('success', 'Data rekapitulasi packing luar berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.rekapitulasi-packing-luar.index')
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
                'exists:rekapitulasi_packing_luars,id',
            ],
        ]);
 
        RekapitulasiPackingLuar::whereIn('id', $request->ids)->delete();
 
        return redirect()
            ->route('operator.rekapitulasi-packing-luar.index')
            ->with('success', 'Data rekapitulasi packing luar yang dipilih berhasil dihapus.');
    }
 
    public function managerIndex(Request $request)
    {
        $query = RekapitulasiPackingLuar::with('productionBatch.product')->latest();
 
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
 
        $rekapitulasiPackingLuars = $query->paginate(10)->withQueryString();
 
        return view('pages.manager.rekapitulasi-packing-luar.index', compact('rekapitulasiPackingLuars'));
    }
 
    public function managerDetail($id)
    {
        $rekapitulasiPackingLuar = RekapitulasiPackingLuar::with('productionBatch.product')->findOrFail($id);
 
        return view('pages.manager.rekapitulasi-packing-luar.detail', compact('rekapitulasiPackingLuar'));
    }
}
