<?php

namespace App\Http\Controllers;

use App\Models\MonitoringPemasakan;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MonitoringPemasakanController extends Controller
{
    public function index(Request $request)
    {
        $query = MonitoringPemasakan::with('productionBatch.product')->latest();

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

        $monitoringPemasakans = $query->paginate(10)->withQueryString();

        return view('pages.operator.monitoring-pemasakan.index', compact('monitoringPemasakans'));
    }

    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.monitoring-pemasakan.create', compact('productionBatches'));
    }

    public function detail($id)
    {
        $monitoringPemasakan = MonitoringPemasakan::with('productionBatch.product')->findOrFail($id);

        return view('pages.operator.monitoring-pemasakan.detail', compact('monitoringPemasakan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'waktu_pemasakan_mulai' => ['nullable', 'date_format:H:i'],
            'waktu_pemasakan_selesai' => ['nullable', 'date_format:H:i'],
            'jumlah_trolly_pcs' => ['nullable', 'numeric'],
            'cooling_down_waktu' => ['nullable', 'numeric'],
            'cooling_down_suhu_ruang' => ['nullable', 'numeric'],
            'cooling_down_suhu_produk' => ['nullable', 'numeric'],
            'pressure_angin' => ['nullable', 'numeric'],
            'tekanan_steam_header' => ['nullable', 'numeric'],
            'smoke_generator' => ['nullable', 'numeric'],
            'downtime_kerusakan' => ['nullable', 'string', 'max:255'],
            'downtime_waktu' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            MonitoringPemasakan::create([
                'production_batch_id' => $request->production_batch_id,
                'waktu_pemasakan_mulai' => $request->waktu_pemasakan_mulai,
                'waktu_pemasakan_selesai' => $request->waktu_pemasakan_selesai,
                'jumlah_trolly_pcs' => $request->jumlah_trolly_pcs,
                'cooling_down_waktu' => $request->cooling_down_waktu,
                'cooling_down_suhu_ruang' => $request->cooling_down_suhu_ruang,
                'cooling_down_suhu_produk' => $request->cooling_down_suhu_produk,
                'pressure_angin' => $request->pressure_angin,
                'tekanan_steam_header' => $request->tekanan_steam_header,
                'smoke_generator' => $request->smoke_generator,
                'downtime_kerusakan' => $request->downtime_kerusakan,
                'downtime_waktu' => $request->downtime_waktu,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.monitoring-pemasakan.index')
                ->with('success', 'Data monitoring pemasakan berhasil disimpan.');
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
        $monitoringPemasakan = MonitoringPemasakan::with('productionBatch.product')->findOrFail($id);

        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.monitoring-pemasakan.edit', compact('monitoringPemasakan', 'productionBatches'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'waktu_pemasakan_mulai' => ['nullable', 'date_format:H:i'],
            'waktu_pemasakan_selesai' => ['nullable', 'date_format:H:i'],
            'jumlah_trolly_pcs' => ['nullable', 'numeric'],
            'cooling_down_waktu' => ['nullable', 'numeric'],
            'cooling_down_suhu_ruang' => ['nullable', 'numeric'],
            'cooling_down_suhu_produk' => ['nullable', 'numeric'],
            'pressure_angin' => ['nullable', 'numeric'],
            'tekanan_steam_header' => ['nullable', 'numeric'],
            'smoke_generator' => ['nullable', 'numeric'],
            'downtime_kerusakan' => ['nullable', 'string', 'max:255'],
            'downtime_waktu' => ['nullable', 'numeric'],
        ]);

        $monitoringPemasakan = MonitoringPemasakan::findOrFail($id);

        DB::beginTransaction();

        try {
            $monitoringPemasakan->update([
                'production_batch_id' => $request->production_batch_id,
                'waktu_pemasakan_mulai' => $request->waktu_pemasakan_mulai,
                'waktu_pemasakan_selesai' => $request->waktu_pemasakan_selesai,
                'jumlah_trolly_pcs' => $request->jumlah_trolly_pcs,
                'cooling_down_waktu' => $request->cooling_down_waktu,
                'cooling_down_suhu_ruang' => $request->cooling_down_suhu_ruang,
                'cooling_down_suhu_produk' => $request->cooling_down_suhu_produk,
                'pressure_angin' => $request->pressure_angin,
                'tekanan_steam_header' => $request->tekanan_steam_header,
                'smoke_generator' => $request->smoke_generator,
                'downtime_kerusakan' => $request->downtime_kerusakan,
                'downtime_waktu' => $request->downtime_waktu,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.monitoring-pemasakan.index')
                ->with('success', 'Data monitoring pemasakan berhasil diperbarui.');
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
            $monitoringPemasakan = MonitoringPemasakan::findOrFail($id);
            $monitoringPemasakan->delete();

            return redirect()
                ->route('operator.monitoring-pemasakan.index')
                ->with('success', 'Data monitoring pemasakan berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.monitoring-pemasakan.index')
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
                'exists:monitoring_pemasakans,id',
            ],
        ]);

        MonitoringPemasakan::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('operator.monitoring-pemasakan.index')
            ->with('success', 'Data monitoring pemasakan yang dipilih berhasil dihapus.');
    }

    public function managerIndex(Request $request)
    {
        $query = MonitoringPemasakan::with('productionBatch.product')->latest();

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

        $monitoringPemasakans = $query->paginate(10)->withQueryString();

        return view('pages.manager.monitoring-pemasakan.index', compact('monitoringPemasakans'));
    }

    public function managerDetail($id)
    {
        $monitoringPemasakan = MonitoringPemasakan::with('productionBatch.product')->findOrFail($id);

        return view('pages.manager.monitoring-pemasakan.detail', compact('monitoringPemasakan'));
    }
}
