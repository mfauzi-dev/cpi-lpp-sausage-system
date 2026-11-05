<?php

namespace App\Http\Controllers;

use App\Models\PackingDalam;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PackingDalamController extends Controller
{
     public function index(Request $request)
    {
        $query = PackingDalam::with('productionBatch.product')->latest();
 
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
 
        $packingDalams = $query->paginate(10)->withQueryString();
 
        return view('pages.operator.packing-dalam.index', compact('packingDalams'));
    }
 
    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.packing-dalam.create', compact('productionBatches'));
    }
 
    public function detail($id)
    {
        $packingDalam = PackingDalam::with('productionBatch.product')->findOrFail($id);
 
        return view('pages.operator.packing-dalam.detail', compact('packingDalam'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'petugas_pengemasan' => ['nullable', 'string', 'max:255'],
            'line_manual_single' => ['nullable', 'string', 'max:255'],
            'line_manual_dimsum' => ['nullable', 'string', 'max:255'],
            'line_manual_baso' => ['nullable', 'string', 'max:255'],
            'line_thermoforming_1' => ['nullable', 'string', 'max:255'],
            'line_thermoforming_2' => ['nullable', 'string', 'max:255'],
            'line_thermoforming_3' => ['nullable', 'string', 'max:255'],
            'waktu_pengemasan_awal' => ['nullable', 'date_format:H:i'],
            'waktu_pengemasan_akhir' => ['nullable', 'date_format:H:i'],
            'downtime_kerusakan' => ['nullable', 'string', 'max:255'],
            'downtime_waktu' => ['nullable', 'numeric', 'min:0'],
        ]);
 
        DB::beginTransaction();
 
        try {
            PackingDalam::create([
                'production_batch_id' => $request->production_batch_id,
                'petugas_pengemasan' => $request->petugas_pengemasan,
                'line_manual_single' => $request->line_manual_single,
                'line_manual_dimsum' => $request->line_manual_dimsum,
                'line_manual_baso' => $request->line_manual_baso,
                'line_thermoforming_1' => $request->line_thermoforming_1,
                'line_thermoforming_2' => $request->line_thermoforming_2,
                'line_thermoforming_3' => $request->line_thermoforming_3,
                'waktu_pengemasan_awal' => $request->waktu_pengemasan_awal,
                'waktu_pengemasan_akhir' => $request->waktu_pengemasan_akhir,
                'downtime_kerusakan' => $request->downtime_kerusakan,
                'downtime_waktu' => $request->downtime_waktu,
            ]);
 
            DB::commit();
 
            return redirect()
                ->route('operator.packing-dalam.index')
                ->with('success', 'Data packing dalam berhasil disimpan.');
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
        $packingDalam = PackingDalam::with('productionBatch.product')->findOrFail($id);
 
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();
 
        return view('pages.operator.packing-dalam.edit', compact('packingDalam', 'productionBatches'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'petugas_pengemasan' => ['nullable', 'string', 'max:255'],
            'line_manual_single' => ['nullable', 'string', 'max:255'],
            'line_manual_dimsum' => ['nullable', 'string', 'max:255'],
            'line_manual_baso' => ['nullable', 'string', 'max:255'],
            'line_thermoforming_1' => ['nullable', 'string', 'max:255'],
            'line_thermoforming_2' => ['nullable', 'string', 'max:255'],
            'line_thermoforming_3' => ['nullable', 'string', 'max:255'],
            'waktu_pengemasan_awal' => ['nullable', 'date_format:H:i'],
            'waktu_pengemasan_akhir' => ['nullable', 'date_format:H:i'],
            'downtime_kerusakan' => ['nullable', 'string', 'max:255'],
            'downtime_waktu' => ['nullable', 'numeric', 'min:0'],
        ]);
 
        $packingDalam = PackingDalam::findOrFail($id);
 
        DB::beginTransaction();
 
        try {
            $packingDalam->update([
                'production_batch_id' => $request->production_batch_id,
                'petugas_pengemasan' => $request->petugas_pengemasan,
                'line_manual_single' => $request->line_manual_single,
                'line_manual_dimsum' => $request->line_manual_dimsum,
                'line_manual_baso' => $request->line_manual_baso,
                'line_thermoforming_1' => $request->line_thermoforming_1,
                'line_thermoforming_2' => $request->line_thermoforming_2,
                'line_thermoforming_3' => $request->line_thermoforming_3,
                'waktu_pengemasan_awal' => $request->waktu_pengemasan_awal,
                'waktu_pengemasan_akhir' => $request->waktu_pengemasan_akhir,
                'downtime_kerusakan' => $request->downtime_kerusakan,
                'downtime_waktu' => $request->downtime_waktu,
            ]);
 
            DB::commit();
 
            return redirect()
                ->route('operator.packing-dalam.index')
                ->with('success', 'Data packing dalam berhasil diperbarui.');
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
            $packingDalam = PackingDalam::findOrFail($id);
            $packingDalam->delete();
 
            return redirect()
                ->route('operator.packing-dalam.index')
                ->with('success', 'Data packing dalam berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.packing-dalam.index')
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
                'exists:packing_dalams,id',
            ],
        ]);
 
        PackingDalam::whereIn('id', $request->ids)->delete();
 
        return redirect()
            ->route('operator.packing-dalam.index')
            ->with('success', 'Data packing dalam yang dipilih berhasil dihapus.');
    }
 
    public function managerIndex(Request $request)
    {
        $query = PackingDalam::with('productionBatch.product')->latest();
 
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
 
        $packingDalams = $query->paginate(10)->withQueryString();
 
        return view('pages.manager.packing-dalam.index', compact('packingDalams'));
    }
 
    public function managerDetail($id)
    {
        $packingDalam = PackingDalam::with('productionBatch.product')->findOrFail($id);
 
        return view('pages.manager.packing-dalam.detail', compact('packingDalam'));
    }
}
