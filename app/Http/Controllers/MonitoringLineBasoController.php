<?php

namespace App\Http\Controllers;

use App\Models\MonitoringLineBaso;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MonitoringLineBasoController extends Controller
{
    public function index(Request $request)
    {
        $query = MonitoringLineBaso::with('productionBatch.product')->latest();

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

        if ($request->filled('line_baso')) {
            $query->where('line_baso', $request->line_baso);
        }

        $monitoringLineBasos = $query->paginate(10)->withQueryString();

        return view('pages.operator.monitoring-line-baso.index', compact('monitoringLineBasos'));
    }

    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.monitoring-line-baso.create', compact('productionBatches'));
    }

    public function detail($id)
    {
        $monitoringLineBaso = MonitoringLineBaso::with('productionBatch.product')->findOrFail($id);

        return view('pages.operator.monitoring-line-baso.detail', compact('monitoringLineBaso'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'line_baso' => ['nullable', 'string', 'max:50'],
            'parameter_pemasakan_suhu_air' => ['nullable', 'numeric'],
            'parameter_pemasakan_suhu_produk' => ['nullable', 'numeric'],
            'parameter_pemasakan_bentuk' => ['nullable', 'string', 'max:255'],
            'waktu_forming_mulai' => ['nullable', 'date_format:H:i'],
            'waktu_forming_selesai' => ['nullable', 'date_format:H:i'],
            'cooling_down_mulai' => ['nullable', 'date_format:H:i'],
            'cooling_down_selesai' => ['nullable', 'date_format:H:i'],
            'suhu_produk_matang' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            MonitoringLineBaso::create([
                'production_batch_id' => $request->production_batch_id,
                'line_baso' => $request->line_baso,
                'parameter_pemasakan_suhu_air' => $request->parameter_pemasakan_suhu_air,
                'parameter_pemasakan_suhu_produk' => $request->parameter_pemasakan_suhu_produk,
                'parameter_pemasakan_bentuk' => $request->parameter_pemasakan_bentuk,
                'waktu_forming_mulai' => $request->waktu_forming_mulai,
                'waktu_forming_selesai' => $request->waktu_forming_selesai,
                'cooling_down_mulai' => $request->cooling_down_mulai,
                'cooling_down_selesai' => $request->cooling_down_selesai,
                'suhu_produk_matang' => $request->suhu_produk_matang,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.monitoring-line-baso.index')
                ->with('success', 'Data monitoring line baso berhasil disimpan.');
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
        $monitoringLineBaso = MonitoringLineBaso::with('productionBatch.product')->findOrFail($id);

        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.monitoring-line-baso.edit', compact('monitoringLineBaso', 'productionBatches'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'line_baso' => ['nullable', 'string', 'max:50'],
            'parameter_pemasakan_suhu_air' => ['nullable', 'numeric'],
            'parameter_pemasakan_suhu_produk' => ['nullable', 'numeric'],
            'parameter_pemasakan_bentuk' => ['nullable', 'string', 'max:255'],
            'waktu_forming_mulai' => ['nullable', 'date_format:H:i'],
            'waktu_forming_selesai' => ['nullable', 'date_format:H:i'],
            'cooling_down_mulai' => ['nullable', 'date_format:H:i'],
            'cooling_down_selesai' => ['nullable', 'date_format:H:i'],
            'suhu_produk_matang' => ['nullable', 'numeric'],
        ]);

        $monitoringLineBaso = MonitoringLineBaso::findOrFail($id);

        DB::beginTransaction();

        try {
            $monitoringLineBaso->update([
                'production_batch_id' => $request->production_batch_id,
                'line_baso' => $request->line_baso,
                'parameter_pemasakan_suhu_air' => $request->parameter_pemasakan_suhu_air,
                'parameter_pemasakan_suhu_produk' => $request->parameter_pemasakan_suhu_produk,
                'parameter_pemasakan_bentuk' => $request->parameter_pemasakan_bentuk,
                'waktu_forming_mulai' => $request->waktu_forming_mulai,
                'waktu_forming_selesai' => $request->waktu_forming_selesai,
                'cooling_down_mulai' => $request->cooling_down_mulai,
                'cooling_down_selesai' => $request->cooling_down_selesai,
                'suhu_produk_matang' => $request->suhu_produk_matang,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.monitoring-line-baso.index')
                ->with('success', 'Data monitoring line baso berhasil diperbarui.');
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
            $monitoringLineBaso = MonitoringLineBaso::findOrFail($id);
            $monitoringLineBaso->delete();

            return redirect()
                ->route('operator.monitoring-line-baso.index')
                ->with('success', 'Data monitoring line baso berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.monitoring-line-baso.index')
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
                'exists:monitoring_line_basos,id',
            ],
        ]);

        MonitoringLineBaso::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('operator.monitoring-line-baso.index')
            ->with('success', 'Data monitoring line baso yang dipilih berhasil dihapus.');
    }

    public function managerIndex(Request $request)
    {
        $query = MonitoringLineBaso::with('productionBatch.product')->latest();

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

        if ($request->filled('line_baso')) {
            $query->where('line_baso', $request->line_baso);
        }

        $monitoringLineBasos = $query->paginate(10)->withQueryString();

        return view('pages.manager.monitoring-line-baso.index', compact('monitoringLineBasos'));
    }

    public function managerDetail($id)
    {
        $monitoringLineBaso = MonitoringLineBaso::with('productionBatch.product')->findOrFail($id);

        return view('pages.manager.monitoring-line-baso.detail', compact('monitoringLineBaso'));
    }
}
