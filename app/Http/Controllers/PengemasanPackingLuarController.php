<?php

namespace App\Http\Controllers;

use App\Models\PengemasanPackingLuar;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PengemasanPackingLuarController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductionBatch::query()->with(['product', 'pengemasanPackingLuars']);

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
            ->whereHas('pengemasanPackingLuars')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.operator.pengemasan-packing-luar.index', compact('productionBatches'));
    }

    public function create()
    {
        $parameterList = [
            'Pengisian ke dalam boks',
            'Sealer boks',
            'Check Weigher',
        ];

        return view('pages.operator.pengemasan-packing-luar.create', compact('parameterList'));
    }

    public function detail($id)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        $records = PengemasanPackingLuar::where('production_batch_id', $productionBatch->id)->get();

        abort_if($records->isEmpty(), 404);

        $dataPengemasan = [];
        foreach ($records as $record) {
            $dataPengemasan[$record->parameter_packing_luar] = $record;
        }

        $parameterList = [
            'Pengisian ke dalam boks',
            'Sealer boks',
            'Check Weigher',
        ];

        return view(
            'pages.operator.pengemasan-packing-luar.detail',
            compact('productionBatch', 'dataPengemasan', 'parameterList')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'pengemasan' => ['required', 'array'],
            'pengemasan.*.parameter_packing_luar' => [
                'required',
                'in:Pengisian ke dalam boks,Sealer boks,Check Weigher',
            ],
            'pengemasan.*.no_mesin' => ['nullable', 'string', 'max:255'],
            'pengemasan.*.petugas' => ['nullable', 'string', 'max:255'],
            'pengemasan.*.foreman' => ['nullable', 'string', 'max:255'],
            'pengemasan.*.kr' => ['nullable', 'string', 'max:255'],
            'pengemasan.*.waktu_awal' => ['nullable', 'date_format:H:i'],
            'pengemasan.*.waktu_akhir' => ['nullable', 'date_format:H:i'],
        ]);

        DB::beginTransaction();

        try {
            $hasData = false;

            foreach ($request->input('pengemasan', []) as $row) {
                $parameter  = $row['parameter_packing_luar'];
                $noMesin    = $row['no_mesin'] ?? null;
                $petugas    = $row['petugas'] ?? null;
                $foreman    = $row['foreman'] ?? null;
                $kr         = $row['kr'] ?? null;
                $waktuAwal  = $row['waktu_awal'] ?? null;
                $waktuAkhir = $row['waktu_akhir'] ?? null;

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

                PengemasanPackingLuar::create([
                    'production_batch_id'    => $request->production_batch_id,
                    'parameter_packing_luar' => $parameter,
                    'no_mesin'               => $noMesin,
                    'petugas'                => $petugas,
                    'foreman'                => $foreman,
                    'kr'                     => $kr,
                    'waktu_awal'             => $waktuAwal,
                    'waktu_akhir'            => $waktuAkhir,
                ]);

                $hasData = true;
            }

            if (!$hasData) {
                throw new \Exception('Minimal satu data pengemasan harus diisi.');
            }

            DB::commit();

            return redirect()
                ->route('operator.pengemasan-packing-luar.index')
                ->with('success', 'Data pengemasan packing luar berhasil disimpan.');
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

        $records = PengemasanPackingLuar::where('production_batch_id', $productionBatch->id)->get();

        $dataPengemasan = [];
        foreach ($records as $record) {
            $dataPengemasan[$record->parameter_packing_luar] = $record;
        }

        $parameterList = [
            'Pengisian ke dalam boks',
            'Sealer boks',
            'Check Weigher',
        ];

        return view(
            'pages.operator.pengemasan-packing-luar.edit',
            compact('productionBatch', 'dataPengemasan', 'parameterList')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pengemasan' => ['required', 'array'],
            'pengemasan.*.parameter_packing_luar' => [
                'required',
                'in:Pengisian ke dalam boks,Sealer boks,Check Weigher',
            ],
            'pengemasan.*.no_mesin' => ['nullable', 'string', 'max:255'],
            'pengemasan.*.petugas' => ['nullable', 'string', 'max:255'],
            'pengemasan.*.foreman' => ['nullable', 'string', 'max:255'],
            'pengemasan.*.kr' => ['nullable', 'string', 'max:255'],
            'pengemasan.*.waktu_awal' => ['nullable', 'date_format:H:i'],
            'pengemasan.*.waktu_akhir' => ['nullable', 'date_format:H:i'],
        ]);

        $productionBatch = ProductionBatch::findOrFail($id);

        DB::beginTransaction();

        try {
            $hasData = false;

            foreach ($request->input('pengemasan', []) as $row) {
                $parameter  = $row['parameter_packing_luar'];
                $noMesin    = $row['no_mesin'] ?? null;
                $petugas    = $row['petugas'] ?? null;
                $foreman    = $row['foreman'] ?? null;
                $kr         = $row['kr'] ?? null;
                $waktuAwal  = $row['waktu_awal'] ?? null;
                $waktuAkhir = $row['waktu_akhir'] ?? null;

                $existing = PengemasanPackingLuar::where('production_batch_id', $productionBatch->id)
                    ->where('parameter_packing_luar', $parameter)
                    ->first();

                if (
                    $noMesin == '' &&
                    $petugas == '' &&
                    $foreman == '' &&
                    $kr == '' &&
                    $waktuAwal == '' &&
                    $waktuAkhir == ''
                ) {
                    if ($existing) {
                        $existing->delete();
                    }
                    continue;
                }

                $data = [
                    'production_batch_id'    => $productionBatch->id,
                    'parameter_packing_luar' => $parameter,
                    'no_mesin'               => $noMesin,
                    'petugas'                => $petugas,
                    'foreman'                => $foreman,
                    'kr'                     => $kr,
                    'waktu_awal'             => $waktuAwal,
                    'waktu_akhir'            => $waktuAkhir,
                ];

                if ($existing) {
                    $existing->update($data);
                } else {
                    PengemasanPackingLuar::create($data);
                }

                $hasData = true;
            }

            if (!$hasData) {
                throw new \Exception('Minimal satu data pengemasan harus diisi.');
            }

            DB::commit();

            return redirect()
                ->route('operator.pengemasan-packing-luar.index')
                ->with('success', 'Data pengemasan packing luar berhasil diperbarui.');
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
            PengemasanPackingLuar::where('production_batch_id', $id)->delete();

            return redirect()
                ->route('operator.pengemasan-packing-luar.index')
                ->with('success', 'Data pengemasan packing luar berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->route('operator.pengemasan-packing-luar.index')
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
                'exists:pengemasan_packing_luars,id',
            ],
        ]);

        PengemasanPackingLuar::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('operator.pengemasan-packing-luar.index')
            ->with('success', 'Data pengemasan packing luar yang dipilih berhasil dihapus.');
    }

    public function managerIndex(Request $request)
    {
        $query = ProductionBatch::query()->with(['product', 'pengemasanPackingLuars']);

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
            ->whereHas('pengemasanPackingLuars')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.manager.pengemasan-packing-luar.index', compact('productionBatches'));
    }

    public function managerDetail($id)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        $records = PengemasanPackingLuar::where('production_batch_id', $productionBatch->id)->get();

        abort_if($records->isEmpty(), 404);

        $dataPengemasan = [];
        foreach ($records as $record) {
            $dataPengemasan[$record->parameter_packing_luar] = $record;
        }

        $parameterList = [
            'Pengisian ke dalam boks',
            'Sealer boks',
            'Check Weigher',
        ];

        return view(
            'pages.manager.pengemasan-packing-luar.detail',
            compact('productionBatch', 'dataPengemasan', 'parameterList')
        );
    }
}