<?php

namespace App\Http\Controllers;

use App\Models\PenggunaanMesin;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PenggunaanMesinController extends Controller
{
    public function index(Request $request)
    {
        $query = PenggunaanMesin::with('productionBatch')->latest();

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

        $penggunaanMesins = $query->paginate(10)->withQueryString();

        return view('pages.operator.penggunaan-mesin.index', compact('penggunaanMesins'));
    }

    public function create()
    {
        $productions = ProductionBatch::latest('tanggal')
            ->latest('id')
            ->get();

        return view('pages.operator.penggunaan-mesin.create', compact('productions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'production_batch_id' => ['required', 'integer', 'exists:production_batches,id'],
            'name' => ['required', 'string', 'max:255'],
            'speed_machine' => ['nullable', 'numeric', 'min:0'],
            'ukuran_holeplate_knife' => ['nullable', 'string', 'max:255'],
            'linker' => ['nullable', 'string', 'max:255'],
            'stuffing_tube' => ['nullable', 'string', 'max:255'],
            'twisting' => ['nullable', 'string', 'max:255'],
            'chuck' => ['nullable', 'string', 'max:255'],
            'waktu_mulai' => ['nullable', 'date_format:H:i'],
            'waktu_selesai' => ['nullable', 'date_format:H:i'],
            'downtime_kerusakan' => ['nullable', 'string'],
            'downtime_lama_waktu' => ['nullable', 'numeric', 'min:0'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                PenggunaanMesin::create([
                    'production_batch_id' => $validated['production_batch_id'],
                    'name' => $validated['name'],
                    'speed_machine' => $validated['speed_machine'] ?? 0,
                    'ukuran_holeplate_knife' => $validated['ukuran_holeplate_knife'] ?? null,
                    'linker' => $validated['linker'] ?? null,
                    'stuffing_tube' => $validated['stuffing_tube'] ?? null,
                    'twisting' => $validated['twisting'] ?? null,
                    'chuck' => $validated['chuck'] ?? null,
                    'waktu_mulai' => $validated['waktu_mulai'] ?? null,
                    'waktu_selesai' => $validated['waktu_selesai'] ?? null,
                    'downtime_kerusakan' => $validated['downtime_kerusakan'] ?? null,
                    'downtime_lama_waktu' => $validated['downtime_lama_waktu'] ?? 0,
                ]);
            });

            return redirect()
                ->route('operator.penggunaan-mesin.index')
                ->with('success', 'Data penggunaan mesin berhasil disimpan.');
        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data penggunaan mesin.');
        }
    }

    public function detail($id)
    {
        $penggunaanMesin = PenggunaanMesin::with('productionBatch')->findOrFail($id);

        return view('pages.operator.penggunaan-mesin.detail', compact('penggunaanMesin'));
    }

    public function edit($id)
    {
        $penggunaanMesin = PenggunaanMesin::with('productionBatch')->findOrFail($id);

        $productions = ProductionBatch::latest('tanggal')
            ->latest('id')
            ->get();

        return view('pages.operator.penggunaan-mesin.edit', compact('penggunaanMesin', 'productions'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'production_batch_id' => ['required', 'integer', 'exists:production_batches,id'],
            'name' => ['required', 'string', 'max:255'],
            'speed_machine' => ['nullable', 'numeric', 'min:0'],
            'ukuran_holeplate_knife' => ['nullable', 'string', 'max:255'],
            'linker' => ['nullable', 'string', 'max:255'],
            'stuffing_tube' => ['nullable', 'string', 'max:255'],
            'twisting' => ['nullable', 'string', 'max:255'],
            'chuck' => ['nullable', 'string', 'max:255'],
            'waktu_mulai' => ['nullable', 'date_format:H:i'],
            'waktu_selesai' => ['nullable', 'date_format:H:i'],
            'downtime_kerusakan' => ['nullable', 'string'],
            'downtime_lama_waktu' => ['nullable', 'numeric', 'min:0'],
        ]);

        $penggunaanMesin = PenggunaanMesin::findOrFail($id);

        $penggunaanMesin->update([
            'production_batch_id' => $validated['production_batch_id'],
            'name' => $validated['name'],
            'speed_machine' => $validated['speed_machine'] ?? 0,
            'ukuran_holeplate_knife' => $validated['ukuran_holeplate_knife'] ?? null,
            'linker' => $validated['linker'] ?? null,
            'stuffing_tube' => $validated['stuffing_tube'] ?? null,
            'twisting' => $validated['twisting'] ?? null,
            'chuck' => $validated['chuck'] ?? null,
            'waktu_mulai' => $validated['waktu_mulai'] ?? null,
            'waktu_selesai' => $validated['waktu_selesai'] ?? null,
            'downtime_kerusakan' => $validated['downtime_kerusakan'] ?? null,
            'downtime_lama_waktu' => $validated['downtime_lama_waktu'] ?? 0,
        ]);

        return redirect()
            ->route('operator.penggunaan-mesin.index')
            ->with('success', 'Data penggunaan mesin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penggunaanMesin = PenggunaanMesin::findOrFail($id);
        $penggunaanMesin->delete();

        return redirect()
            ->route('operator.penggunaan-mesin.index')
            ->with('success', 'Data penggunaan mesin berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:penggunaan_mesins,id',
            ],
        ]);

        PenggunaanMesin::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('operator.penggunaan-mesin.index')
            ->with('success', 'Data penggunaan mesin yang dipilih berhasil dihapus.');
    }

    public function managerIndex(Request $request)
    {
        $query = PenggunaanMesin::with('productionBatch')->latest();

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

        $penggunaanMesins = $query->paginate(10)->withQueryString();

        return view('pages.manager.penggunaan-mesin.index', compact('penggunaanMesins'));
    }

    public function managerDetail($id)
    {
        $penggunaanMesin = PenggunaanMesin::with('productionBatch')->findOrFail($id);

        return view('pages.manager.penggunaan-mesin.detail', compact('penggunaanMesin'));
    }
}
