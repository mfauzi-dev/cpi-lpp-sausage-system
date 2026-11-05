<?php

namespace App\Http\Controllers;

use App\Models\PackingLuar;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PackingLuarController extends Controller
{
        public function index(Request $request)
    {
        $query = PackingLuar::with('productionBatch.product')->latest();

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

        $packingLuars = $query->paginate(10)->withQueryString();

        return view('pages.operator.packing-luar.index', compact('packingLuars'));
    }

    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.packing-luar.create', compact('productionBatches'));
    }

    public function detail($id)
    {
        $packingLuar = PackingLuar::with('productionBatch.product')->findOrFail($id);

        return view('pages.operator.packing-luar.detail', compact('packingLuar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'proses_freezing' => ['nullable', 'string', 'max:255'],
            'jumlah_input' => ['nullable', 'numeric', 'min:0'],
            'suhu_iqf' => ['nullable', 'numeric'],
            'suhu_produk' => ['nullable', 'numeric'],
            'dweling_time' => ['nullable', 'string', 'max:255'],
            'waktu_awal' => ['nullable', 'date_format:H:i'],
            'waktu_akhir' => ['nullable', 'date_format:H:i'],
            'downtime_kerusakan' => ['nullable', 'string', 'max:255'],
            'downtime_waktu' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();

        try {
            PackingLuar::create([
                'production_batch_id' => $request->production_batch_id,
                'proses_freezing' => $request->proses_freezing,
                'jumlah_input' => $request->jumlah_input,
                'suhu_iqf' => $request->suhu_iqf,
                'suhu_produk' => $request->suhu_produk,
                'dweling_time' => $request->dweling_time,
                'waktu_awal' => $request->waktu_awal,
                'waktu_akhir' => $request->waktu_akhir,
                'downtime_kerusakan' => $request->downtime_kerusakan,
                'downtime_waktu' => $request->downtime_waktu,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.packing-luar.index')
                ->with('success', 'Data packing luar berhasil disimpan.');
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
        $packingLuar = PackingLuar::with('productionBatch.product')->findOrFail($id);

        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.packing-luar.edit', compact('packingLuar', 'productionBatches'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'proses_freezing' => ['nullable', 'string', 'max:255'],
            'jumlah_input' => ['nullable', 'numeric', 'min:0'],
            'suhu_iqf' => ['nullable', 'numeric'],
            'suhu_produk' => ['nullable', 'numeric'],
            'dweling_time' => ['nullable', 'string', 'max:255'],
            'waktu_awal' => ['nullable', 'date_format:H:i'],
            'waktu_akhir' => ['nullable', 'date_format:H:i'],
            'downtime_kerusakan' => ['nullable', 'string', 'max:255'],
            'downtime_waktu' => ['nullable', 'numeric', 'min:0'],
        ]);

        $packingLuar = PackingLuar::findOrFail($id);

        DB::beginTransaction();

        try {
            $packingLuar->update([
                'production_batch_id' => $request->production_batch_id,
                'proses_freezing' => $request->proses_freezing,
                'jumlah_input' => $request->jumlah_input,
                'suhu_iqf' => $request->suhu_iqf,
                'suhu_produk' => $request->suhu_produk,
                'dweling_time' => $request->dweling_time,
                'waktu_awal' => $request->waktu_awal,
                'waktu_akhir' => $request->waktu_akhir,
                'downtime_kerusakan' => $request->downtime_kerusakan,
                'downtime_waktu' => $request->downtime_waktu,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.packing-luar.index')
                ->with('success', 'Data packing luar berhasil diperbarui.');
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
            $packingLuar = PackingLuar::findOrFail($id);
            $packingLuar->delete();

            return redirect()
                ->route('operator.packing-luar.index')
                ->with('success', 'Data packing luar berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.packing-luar.index')
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
                'exists:packing_luars,id',
            ],
        ]);

        PackingLuar::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('operator.packing-luar.index')
            ->with('success', 'Data packing luar yang dipilih berhasil dihapus.');
    }

    public function managerIndex(Request $request)
    {
        $query = PackingLuar::with('productionBatch.product')->latest();

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

        $packingLuars = $query->paginate(10)->withQueryString();

        return view('pages.manager.packing-luar.index', compact('packingLuars'));
    }

    public function managerDetail($id)
    {
        $packingLuar = PackingLuar::with('productionBatch.product')->findOrFail($id);

        return view('pages.manager.packing-luar.detail', compact('packingLuar'));
    }
}
