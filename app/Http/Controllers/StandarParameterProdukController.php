<?php

namespace App\Http\Controllers;

use App\Models\StandarParameterProduk;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StandarParameterProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductionBatch::query()
            ->withCount('standarParameterProduks')
            ->with('product');

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
            ->whereHas('standarParameterProduks')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.operator.standar-parameter-produk.index', compact('productionBatches'));
    }

    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.standar-parameter-produk.create', compact('productionBatches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'sampling' => ['nullable', 'array'],
            'sampling.*.sampling_ke' => ['required', 'integer', 'min:1'],
            'sampling.*.diameter' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.panjang' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.berat_per_pcs' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.berat_kulit' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.berat_adonan' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();

        try {
            $hasSampling = false;

            foreach ($request->input('sampling', []) as $row) {
                $isFilled = collect($row)->contains(function ($value) {
                    return $value !== null && $value !== '';
                });

                if ($isFilled) {
                    StandarParameterProduk::create([
                        'production_batch_id' => $request->production_batch_id,
                        'sampling_ke' => $row['sampling_ke'],
                        'diameter' => $row['diameter'] ?? null,
                        'panjang' => $row['panjang'] ?? null,
                        'berat_per_pcs' => $row['berat_per_pcs'] ?? null,
                        'berat_kulit' => $row['berat_kulit'] ?? null,
                        'berat_adonan' => $row['berat_adonan'] ?? null,
                    ]);

                    $hasSampling = true;
                }
            }

            if (!$hasSampling) {
                throw new \Exception('Minimal satu data sampling harus diisi.');
            }

            DB::commit();

            return redirect()
                ->route('operator.standar-parameter-produk.index')
                ->with('success', 'Standar parameter produk berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan standar parameter produk: ' . $e->getMessage());
        }
    }

    public function detail($productionBatchId)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);

        $standarParameterProduks = StandarParameterProduk::where('production_batch_id', $productionBatch->id)
            ->orderBy('sampling_ke')
            ->get();

        abort_if($standarParameterProduks->isEmpty(), 404);

        return view(
            'pages.operator.standar-parameter-produk.detail',
            compact('productionBatch', 'standarParameterProduks')
        );
    }

    public function edit($id)
    {
        $standarParameterProduk = StandarParameterProduk::findOrFail($id);

        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view(
            'pages.operator.standar-parameter-produk.edit',
            compact('standarParameterProduk', 'productionBatches')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'sampling_ke' => ['required', 'integer', 'min:1'],
            'diameter' => ['nullable', 'numeric', 'min:0'],
            'panjang' => ['nullable', 'numeric', 'min:0'],
            'berat_per_pcs' => ['nullable', 'numeric', 'min:0'],
            'berat_kulit' => ['nullable', 'numeric', 'min:0'],
            'berat_adonan' => ['nullable', 'numeric', 'min:0'],
        ]);

        $standarParameterProduk = StandarParameterProduk::findOrFail($id);

        $standarParameterProduk->update($request->only([
            'production_batch_id',
            'sampling_ke',
            'diameter',
            'panjang',
            'berat_per_pcs',
            'berat_kulit',
            'berat_adonan',
        ]));

        return redirect()
            ->route('operator.standar-parameter-produk.detail', $standarParameterProduk->production_batch_id)
            ->with('success', 'Standar parameter produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $standarParameterProduk = StandarParameterProduk::findOrFail($id);
            $productionBatchId = $standarParameterProduk->production_batch_id;

            $standarParameterProduk->delete();

            $remaining = StandarParameterProduk::where('production_batch_id', $productionBatchId)->count();

            return redirect()
                ->route(
                    $remaining > 0
                        ? 'operator.standar-parameter-produk.detail'
                        : 'operator.standar-parameter-produk.index',
                    $remaining > 0 ? $productionBatchId : []
                )
                ->with('success', 'Standar parameter produk berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus standar parameter produk: ' . $e->getMessage());
        }
    }

    public function managerIndex(Request $request)
    {
        $query = ProductionBatch::query()
            ->withCount('standarParameterProduks')
            ->with('product');

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
            ->whereHas('standarParameterProduks')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.manager.standar-parameter-produk.index', compact('productionBatches'));
    }

    public function managerDetail($productionBatchId)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);

        $standarParameterProduks = StandarParameterProduk::where('production_batch_id', $productionBatch->id)
            ->orderBy('sampling_ke')
            ->get();

        abort_if($standarParameterProduks->isEmpty(), 404);

        return view(
            'pages.manager.standar-parameter-produk.detail',
            compact('productionBatch', 'standarParameterProduks')
        );
    }
}