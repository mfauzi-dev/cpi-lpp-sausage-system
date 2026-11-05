<?php

namespace App\Http\Controllers;

use App\Models\ProductionBatch;
use App\Models\Reject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RejectController extends Controller
{
    public function index(Request $request)
    {
        $query = Reject::with('productionBatch.product')->latest();

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

        $rejects = $query->paginate(10)->withQueryString();

        return view('pages.operator.reject.index', compact('rejects'));
    }

    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.reject.create', compact('productionBatches'));
    }

    public function detail($id)
    {
        $reject = Reject::with('productionBatch.product')->findOrFail($id);

        return view('pages.operator.reject.detail', compact('reject'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'lepas_twisting_cooking' => ['nullable', 'numeric', 'min:0'],
            'lepas_twisting_packing' => ['nullable', 'numeric', 'min:0'],
            'jatuh_cooking' => ['nullable', 'numeric', 'min:0'],
            'jatuh_packing' => ['nullable', 'numeric', 'min:0'],
            'potong_cooking' => ['nullable', 'numeric', 'min:0'],
            'potong_packing' => ['nullable', 'numeric', 'min:0'],
        ]);

        $totalRijekCooking = (float) ($validated['lepas_twisting_cooking'] ?? 0)
            + (float) ($validated['jatuh_cooking'] ?? 0)
            + (float) ($validated['potong_cooking'] ?? 0);

        $totalRijekPacking = (float) ($validated['lepas_twisting_packing'] ?? 0)
            + (float) ($validated['jatuh_packing'] ?? 0)
            + (float) ($validated['potong_packing'] ?? 0);

        DB::beginTransaction();

        try {
            Reject::create([
                'production_batch_id' => $validated['production_batch_id'],
                'lepas_twisting_cooking' => $validated['lepas_twisting_cooking'] ?? 0,
                'lepas_twisting_packing' => $validated['lepas_twisting_packing'] ?? 0,
                'jatuh_cooking' => $validated['jatuh_cooking'] ?? 0,
                'jatuh_packing' => $validated['jatuh_packing'] ?? 0,
                'potong_cooking' => $validated['potong_cooking'] ?? 0,
                'potong_packing' => $validated['potong_packing'] ?? 0,
                'total_rijek_cooking_kg' => $totalRijekCooking,
                'total_rijek_packing_kg' => $totalRijekPacking,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.reject.index')
                ->with('success', 'Data reject berhasil disimpan.');
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
        $reject = Reject::with('productionBatch.product')->findOrFail($id);

        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.reject.edit', compact('reject', 'productionBatches'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'lepas_twisting_cooking' => ['nullable', 'numeric', 'min:0'],
            'lepas_twisting_packing' => ['nullable', 'numeric', 'min:0'],
            'jatuh_cooking' => ['nullable', 'numeric', 'min:0'],
            'jatuh_packing' => ['nullable', 'numeric', 'min:0'],
            'potong_cooking' => ['nullable', 'numeric', 'min:0'],
            'potong_packing' => ['nullable', 'numeric', 'min:0'],
        ]);

        $totalRijekCooking = (float) ($validated['lepas_twisting_cooking'] ?? 0)
            + (float) ($validated['jatuh_cooking'] ?? 0)
            + (float) ($validated['potong_cooking'] ?? 0);

        $totalRijekPacking = (float) ($validated['lepas_twisting_packing'] ?? 0)
            + (float) ($validated['jatuh_packing'] ?? 0)
            + (float) ($validated['potong_packing'] ?? 0);

        DB::beginTransaction();

        try {
            $reject = Reject::findOrFail($id);

            $reject->update([
                'production_batch_id' => $validated['production_batch_id'],
                'lepas_twisting_cooking' => $validated['lepas_twisting_cooking'] ?? 0,
                'lepas_twisting_packing' => $validated['lepas_twisting_packing'] ?? 0,
                'jatuh_cooking' => $validated['jatuh_cooking'] ?? 0,
                'jatuh_packing' => $validated['jatuh_packing'] ?? 0,
                'potong_cooking' => $validated['potong_cooking'] ?? 0,
                'potong_packing' => $validated['potong_packing'] ?? 0,
                'total_rijek_cooking_kg' => $totalRijekCooking,
                'total_rijek_packing_kg' => $totalRijekPacking,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.reject.index')
                ->with('success', 'Data reject berhasil diperbarui.');
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
            $reject = Reject::findOrFail($id);
            $reject->delete();

            return redirect()
                ->route('operator.reject.index')
                ->with('success', 'Data reject berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('operator.reject.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function managerIndex(Request $request)
    {
        $query = Reject::with('productionBatch.product')->latest();

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

        $rejects = $query->paginate(10)->withQueryString();

        return view('pages.manager.reject.index', compact('rejects'));
    }

    public function managerDetail($id)
    {
        $reject = Reject::with('productionBatch.product')->findOrFail($id);

        return view('pages.manager.reject.detail', compact('reject'));
    }
}
