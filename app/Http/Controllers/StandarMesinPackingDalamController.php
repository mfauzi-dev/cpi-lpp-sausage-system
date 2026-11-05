<?php

namespace App\Http\Controllers;

use App\Models\ProductionBatch;
use App\Models\StandarMesinPackingDalam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class StandarMesinPackingDalamController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductionBatch::query()->with(['product', 'standarMesinPackingDalams']);

        if ($request->filled('kode_batch')) {
            $query->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }

        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        $productionBatches = $query
            ->whereHas('standarMesinPackingDalams')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.operator.standar-mesin-packing-dalam.index', compact('productionBatches'));
    }

    public function create()
    {
        $parameterList = [
            'Speed',
            'Tekanan',
            'Seal',
            'Angin',
            'Suhu Forming (°C)',
            'Vacuum Forming Time (s)',
            'Air Forming Time (s)',
            'Forming Ventilation Time (s)',
            'Suhu Sealing (°C)',
            'Sealing Time (s)',
            'Vacuum Time (mbar)',
            'Penggunaan Filler Plate',
            'Cycle',
        ];

        return view('pages.operator.standar-mesin-packing-dalam.create', compact('parameterList'));
    }

    public function detail($id)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        $records = StandarMesinPackingDalam::where('production_batch_id', $productionBatch->id)->get();

        abort_if($records->isEmpty(), 404);

        // susun berdasarkan parameter mesin
        $dataStandar = [];
        foreach ($records as $record) {
            $dataStandar[$record->parameter_mesin] = $record;
        }

        $parameterList = [
            'Speed',
            'Tekanan',
            'Seal',
            'Angin',
            'Suhu Forming (°C)',
            'Vacuum Forming Time (s)',
            'Air Forming Time (s)',
            'Forming Ventilation Time (s)',
            'Suhu Sealing (°C)',
            'Sealing Time (s)',
            'Vacuum Time (mbar)',
            'Penggunaan Filler Plate',
            'Cycle',
        ];

        return view(
            'pages.operator.standar-mesin-packing-dalam.detail',
            compact('productionBatch', 'dataStandar', 'parameterList')
        );
    }

    public function store(Request $request)
    {
        $parameterList = [
            'Speed',
            'Tekanan',
            'Seal',
            'Angin',
            'Suhu Forming (°C)',
            'Vacuum Forming Time (s)',
            'Air Forming Time (s)',
            'Forming Ventilation Time (s)',
            'Suhu Sealing (°C)',
            'Sealing Time (s)',
            'Vacuum Time (mbar)',
            'Penggunaan Filler Plate',
            'Cycle',
        ];

        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'standar' => ['required', 'array'],
            'standar.*.parameter_mesin' => ['required', 'in:' . implode(',', $parameterList)],
            'standar.*.penggunaan_mesin_sausage_cutter' => ['nullable', 'string', 'max:255'],
            'standar.*.penggunaan_mesin_vacuum_pack' => ['nullable', 'string', 'max:255'],
            'standar.*.penggunaan_mesin_thermoforming' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            $hasData = false;

            foreach ($request->input('standar', []) as $row) {
                $parameter     = $row['parameter_mesin'];
                $sausageCutter = $row['penggunaan_mesin_sausage_cutter'] ?? null;
                $vacuumPack    = $row['penggunaan_mesin_vacuum_pack'] ?? null;
                $thermoforming = $row['penggunaan_mesin_thermoforming'] ?? null;

                // kalau semua kolom kosong, lewati baris ini
                if ($sausageCutter == '' && $vacuumPack == '' && $thermoforming == '') {
                    continue;
                }

                StandarMesinPackingDalam::create([
                    'production_batch_id' => $request->production_batch_id,
                    'parameter_mesin' => $parameter,
                    'penggunaan_mesin_sausage_cutter' => $sausageCutter,
                    'penggunaan_mesin_vacuum_pack' => $vacuumPack,
                    'penggunaan_mesin_thermoforming' => $thermoforming,
                ]);

                $hasData = true;
            }

            if (!$hasData) {
                throw new \Exception('Minimal satu data parameter mesin harus diisi.');
            }

            DB::commit();

            return redirect()
                ->route('operator.standar-mesin-packing-dalam.index')
                ->with('success', 'Data standar mesin packing dalam berhasil disimpan.');
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
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        $records = StandarMesinPackingDalam::where('production_batch_id', $productionBatch->id)->get();

        // susun berdasarkan parameter mesin
        $dataStandar = [];
        foreach ($records as $record) {
            $dataStandar[$record->parameter_mesin] = $record;
        }

        $parameterList = [
            'Speed',
            'Tekanan',
            'Seal',
            'Angin',
            'Suhu Forming (°C)',
            'Vacuum Forming Time (s)',
            'Air Forming Time (s)',
            'Forming Ventilation Time (s)',
            'Suhu Sealing (°C)',
            'Sealing Time (s)',
            'Vacuum Time (mbar)',
            'Penggunaan Filler Plate',
            'Cycle',
        ];

        return view(
            'pages.operator.standar-mesin-packing-dalam.edit',
            compact('productionBatch', 'dataStandar', 'parameterList')
        );
    }

    public function update(Request $request, $id)
    {
        $parameterList = [
            'Speed',
            'Tekanan',
            'Seal',
            'Angin',
            'Suhu Forming (°C)',
            'Vacuum Forming Time (s)',
            'Air Forming Time (s)',
            'Forming Ventilation Time (s)',
            'Suhu Sealing (°C)',
            'Sealing Time (s)',
            'Vacuum Time (mbar)',
            'Penggunaan Filler Plate',
            'Cycle',
        ];

        $request->validate([
            'standar' => ['required', 'array'],
            'standar.*.parameter_mesin' => ['required', 'in:' . implode(',', $parameterList)],
            'standar.*.penggunaan_mesin_sausage_cutter' => ['nullable', 'string', 'max:255'],
            'standar.*.penggunaan_mesin_vacuum_pack' => ['nullable', 'string', 'max:255'],
            'standar.*.penggunaan_mesin_thermoforming' => ['nullable', 'string', 'max:255'],
        ]);

        $productionBatch = ProductionBatch::findOrFail($id);

        DB::beginTransaction();

        try {
            $hasData = false;

            foreach ($request->input('standar', []) as $row) {
                $parameter     = $row['parameter_mesin'];
                $sausageCutter = $row['penggunaan_mesin_sausage_cutter'] ?? null;
                $vacuumPack    = $row['penggunaan_mesin_vacuum_pack'] ?? null;
                $thermoforming = $row['penggunaan_mesin_thermoforming'] ?? null;

                // cari data lama untuk batch + parameter ini
                $existing = StandarMesinPackingDalam::where('production_batch_id', $productionBatch->id)
                    ->where('parameter_mesin', $parameter)
                    ->first();

                // kalau semua kolom kosong
                if ($sausageCutter == '' && $vacuumPack == '' && $thermoforming == '') {
                    // data lama dihapus kalau ada, lalu lewati baris ini
                    if ($existing) {
                        $existing->delete();
                    }
                    continue;
                }

                $data = [
                    'production_batch_id' => $productionBatch->id,
                    'parameter_mesin' => $parameter,
                    'penggunaan_mesin_sausage_cutter' => $sausageCutter,
                    'penggunaan_mesin_vacuum_pack' => $vacuumPack,
                    'penggunaan_mesin_thermoforming' => $thermoforming,
                ];

                if ($existing) {
                    $existing->update($data);
                } else {
                    StandarMesinPackingDalam::create($data);
                }

                $hasData = true;
            }

            if (!$hasData) {
                throw new \Exception('Minimal satu data parameter mesin harus diisi.');
            }

            DB::commit();

            return redirect()
                ->route('operator.standar-mesin-packing-dalam.index')
                ->with('success', 'Data standar mesin packing dalam berhasil diperbarui.');
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
            // hapus semua parameter milik batch ini
            StandarMesinPackingDalam::where('production_batch_id', $id)->delete();

            return redirect()
                ->route('operator.standar-mesin-packing-dalam.index')
                ->with('success', 'Data standar mesin packing dalam berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.standar-mesin-packing-dalam.index')
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
                'exists:standar_mesin_packing_dalams,id',
            ],
        ]);

        StandarMesinPackingDalam::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('operator.standar-mesin-packing-dalam.index')
            ->with('success', 'Data standar mesin packing dalam yang dipilih berhasil dihapus.');
    }

    public function managerIndex(Request $request)
    {
        $query = ProductionBatch::query()->with(['product', 'standarMesinPackingDalams']);

        if ($request->filled('kode_batch')) {
            $query->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }

        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        $productionBatches = $query
            ->whereHas('standarMesinPackingDalams')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.manager.standar-mesin-packing-dalam.index', compact('productionBatches'));
    }

    public function managerDetail($id)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        $records = StandarMesinPackingDalam::where('production_batch_id', $productionBatch->id)->get();

        abort_if($records->isEmpty(), 404);

        // susun berdasarkan parameter mesin
        $dataStandar = [];
        foreach ($records as $record) {
            $dataStandar[$record->parameter_mesin] = $record;
        }

        $parameterList = [
            'Speed',
            'Tekanan',
            'Seal',
            'Angin',
            'Suhu Forming (°C)',
            'Vacuum Forming Time (s)',
            'Air Forming Time (s)',
            'Forming Ventilation Time (s)',
            'Suhu Sealing (°C)',
            'Sealing Time (s)',
            'Vacuum Time (mbar)',
            'Penggunaan Filler Plate',
            'Cycle',
        ];

        return view(
            'pages.manager.standar-mesin-packing-dalam.detail',
            compact('productionBatch', 'dataStandar', 'parameterList')
        );
    }
}