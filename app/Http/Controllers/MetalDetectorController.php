<?php

namespace App\Http\Controllers;

use App\Models\MetalDetector;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MetalDetectorController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductionBatch::query()->with(['product', 'metalDetectors']);

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
            ->whereHas('metalDetectors')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.operator.metal-detector.index', compact('productionBatches'));
    }

    public function create()
    {
        return view('pages.operator.metal-detector.create');
    }

    public function detail($id)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        $records = MetalDetector::where('production_batch_id', $productionBatch->id)->get();

        abort_if($records->isEmpty(), 404);

        // susun berdasarkan jenis pemeriksaan
        $dataPemeriksaan = [];
        foreach ($records as $record) {
            $dataPemeriksaan[$record->jenis_pemeriksaan] = $record;
        }

        $jenisList = ['Metal Detector', 'Fe / Sus / Non Fe', 'Timbangan'];

        return view(
            'pages.operator.metal-detector.detail',
            compact('productionBatch', 'dataPemeriksaan', 'jenisList')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'pemeriksaan' => ['required', 'array'],
            'pemeriksaan.*.jenis_pemeriksaan' => [
                'required',
                'in:Metal Detector,Fe / Sus / Non Fe,Timbangan',
            ],
            'pemeriksaan.*.no_mesin' => ['nullable', 'string', 'max:255'],
            'pemeriksaan.*.petugas' => ['nullable', 'string', 'max:255'],
            'pemeriksaan.*.foreman' => ['nullable', 'string', 'max:255'],
            'pemeriksaan.*.kr' => ['nullable', 'string', 'max:255'],
            'pemeriksaan.*.waktu_awal' => ['nullable', 'date_format:H:i'],
            'pemeriksaan.*.waktu_akhir' => ['nullable', 'date_format:H:i'],
        ]);

        DB::beginTransaction();

        try {
            $hasData = false;

            foreach ($request->input('pemeriksaan', []) as $row) {
                $jenis      = $row['jenis_pemeriksaan'];
                $noMesin    = $row['no_mesin'] ?? null;
                $petugas    = $row['petugas'] ?? null;
                $foreman    = $row['foreman'] ?? null;
                $kr         = $row['kr'] ?? null;
                $waktuAwal  = $row['waktu_awal'] ?? null;
                $waktuAkhir = $row['waktu_akhir'] ?? null;

                // kalau semua kolom kosong, lewati baris ini
                if (
                    $noMesin == '' &&
                    $petugas == '' &&
                    $foreman == '' &&
                    $kr == '' &&
                    $waktuAwal == '' &&
                    $waktuAkhir == ''
                ) {
                    continue;
                }

                MetalDetector::create([
                    'production_batch_id' => $request->production_batch_id,
                    'jenis_pemeriksaan'   => $jenis,
                    'no_mesin'            => $noMesin,
                    'petugas'             => $petugas,
                    'foreman'             => $foreman,
                    'kr'                  => $kr,
                    'waktu_awal'          => $waktuAwal,
                    'waktu_akhir'         => $waktuAkhir,
                ]);

                $hasData = true;
            }

            if (!$hasData) {
                throw new \Exception('Minimal satu data pemeriksaan harus diisi.');
            }

            DB::commit();

            return redirect()
                ->route('operator.metal-detector.index')
                ->with('success', 'Data metal detector berhasil disimpan.');
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

        $records = MetalDetector::where('production_batch_id', $productionBatch->id)->get();

        // susun berdasarkan jenis pemeriksaan
        $dataPemeriksaan = [];
        foreach ($records as $record) {
            $dataPemeriksaan[$record->jenis_pemeriksaan] = $record;
        }

        return view('pages.operator.metal-detector.edit', compact('productionBatch', 'dataPemeriksaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pemeriksaan' => ['required', 'array'],
            'pemeriksaan.*.jenis_pemeriksaan' => [
                'required',
                'in:Metal Detector,Fe / Sus / Non Fe,Timbangan',
            ],
            'pemeriksaan.*.no_mesin' => ['nullable', 'string', 'max:255'],
            'pemeriksaan.*.petugas' => ['nullable', 'string', 'max:255'],
            'pemeriksaan.*.foreman' => ['nullable', 'string', 'max:255'],
            'pemeriksaan.*.kr' => ['nullable', 'string', 'max:255'],
            'pemeriksaan.*.waktu_awal' => ['nullable', 'date_format:H:i'],
            'pemeriksaan.*.waktu_akhir' => ['nullable', 'date_format:H:i'],
        ]);

        $productionBatch = ProductionBatch::findOrFail($id);

        DB::beginTransaction();

        try {
            $hasData = false;

            foreach ($request->input('pemeriksaan', []) as $row) {
                $jenis      = $row['jenis_pemeriksaan'];
                $noMesin    = $row['no_mesin'] ?? null;
                $petugas    = $row['petugas'] ?? null;
                $foreman    = $row['foreman'] ?? null;
                $kr         = $row['kr'] ?? null;
                $waktuAwal  = $row['waktu_awal'] ?? null;
                $waktuAkhir = $row['waktu_akhir'] ?? null;

                // cari data lama untuk batch + jenis ini
                $existing = MetalDetector::where('production_batch_id', $productionBatch->id)
                    ->where('jenis_pemeriksaan', $jenis)
                    ->first();

                // kalau semua kolom kosong
                if (
                    $noMesin == '' &&
                    $petugas == '' &&
                    $foreman == '' &&
                    $kr == '' &&
                    $waktuAwal == '' &&
                    $waktuAkhir == ''
                ) {
                    // data lama dihapus kalau ada, lalu lewati baris ini
                    if ($existing) {
                        $existing->delete();
                    }
                    continue;
                }

                $data = [
                    'production_batch_id' => $productionBatch->id,
                    'jenis_pemeriksaan'   => $jenis,
                    'no_mesin'            => $noMesin,
                    'petugas'             => $petugas,
                    'foreman'             => $foreman,
                    'kr'                  => $kr,
                    'waktu_awal'          => $waktuAwal,
                    'waktu_akhir'         => $waktuAkhir,
                ];

                if ($existing) {
                    $existing->update($data);
                } else {
                    MetalDetector::create($data);
                }

                $hasData = true;
            }

            if (!$hasData) {
                throw new \Exception('Minimal satu data pemeriksaan harus diisi.');
            }

            DB::commit();

            return redirect()
                ->route('operator.metal-detector.index')
                ->with('success', 'Data metal detector berhasil diperbarui.');
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
            // hapus semua jenis pemeriksaan milik batch ini
            MetalDetector::where('production_batch_id', $id)->delete();

            return redirect()
                ->route('operator.metal-detector.index')
                ->with('success', 'Data metal detector berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.metal-detector.index')
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
                'exists:metal_detectors,id',
            ],
        ]);

        MetalDetector::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('operator.metal-detector.index')
            ->with('success', 'Data metal detector yang dipilih berhasil dihapus.');
    }

    public function managerIndex(Request $request)
    {
        $query = ProductionBatch::query()->with(['product', 'metalDetectors']);

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
            ->whereHas('metalDetectors')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.manager.metal-detector.index', compact('productionBatches'));
    }

    public function managerDetail($id)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        $records = MetalDetector::where('production_batch_id', $productionBatch->id)->get();

        abort_if($records->isEmpty(), 404);

        // susun berdasarkan jenis pemeriksaan
        $dataPemeriksaan = [];
        foreach ($records as $record) {
            $dataPemeriksaan[$record->jenis_pemeriksaan] = $record;
        }

        $jenisList = ['Metal Detector', 'Fe / Sus / Non Fe', 'Timbangan'];

        return view(
            'pages.manager.metal-detector.detail',
            compact('productionBatch', 'dataPemeriksaan', 'jenisList')
        );
    }
}