<?php

namespace App\Http\Controllers;

use App\Models\ParameterProduk;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParameterProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductionBatch::query()
            ->withCount('parameterProduks')
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
            ->whereHas('parameterProduks')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.operator.parameter-produk.index', compact('productionBatches'));
    }

    public function create()
    {
        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.parameter-produk.create', compact('productionBatches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'sampling' => ['nullable', 'array'],
            'sampling.*.sampling_ke' => ['required', 'integer', 'min:1'],
            'sampling.*.berat_per_3pcs' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.diameter' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.panjang' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.berat_per_pcs' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.berat_kulit' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.berat_adonan' => ['nullable', 'numeric', 'min:0'],
            'sampling.*.berat_per_3pcs_akhir' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();

        try {
            $hasSampling = false;

            foreach ($request->input('sampling', []) as $row) {
                $isFilled = collect($row)->contains(function ($value) {
                    return $value !== null && $value !== '';
                });

                if ($isFilled) {
                    ParameterProduk::create([
                        'production_batch_id' => $request->production_batch_id,
                        'sampling_ke' => $row['sampling_ke'],
                        'berat_per_3pcs' => $row['berat_per_3pcs'] ?? null,
                        'diameter' => $row['diameter'] ?? null,
                        'panjang' => $row['panjang'] ?? null,
                        'berat_per_pcs' => $row['berat_per_pcs'] ?? null,
                        'berat_kulit' => $row['berat_kulit'] ?? null,
                        'berat_adonan' => $row['berat_adonan'] ?? null,
                        'berat_per_3pcs_akhir' => $row['berat_per_3pcs_akhir'] ?? null,
                    ]);

                    $hasSampling = true;
                }
            }

            if (!$hasSampling) {
                throw new \Exception('Minimal satu data sampling harus diisi.');
            }

            DB::commit();

            return redirect()
                ->route('operator.parameter-produk.index')
                ->with('success', 'Parameter produk berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan parameter produk: ' . $e->getMessage());
        }
    }

    public function detail($productionBatchId)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);

        $parameterProduks = ParameterProduk::where('production_batch_id', $productionBatch->id)
            ->orderBy('sampling_ke')
            ->get();

        abort_if($parameterProduks->isEmpty(), 404);

        return view(
            'pages.operator.parameter-produk.detail',
            compact('productionBatch', 'parameterProduks')
        );
    }

    public function edit($id)
    {
        $parameterProduk = ParameterProduk::findOrFail($id);

        $productionBatches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->get();

        return view('pages.operator.parameter-produk.edit', compact('parameterProduk', 'productionBatches'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'production_batch_id' => ['required', 'exists:production_batches,id'],
            'sampling_ke' => ['required', 'integer', 'min:1'],
            'berat_per_3pcs' => ['nullable', 'numeric', 'min:0'],
            'diameter' => ['nullable', 'numeric', 'min:0'],
            'panjang' => ['nullable', 'numeric', 'min:0'],
            'berat_per_pcs' => ['nullable', 'numeric', 'min:0'],
            'berat_kulit' => ['nullable', 'numeric', 'min:0'],
            'berat_adonan' => ['nullable', 'numeric', 'min:0'],
            'berat_per_3pcs_akhir' => ['nullable', 'numeric', 'min:0'],
        ]);

        $parameterProduk = ParameterProduk::findOrFail($id);

        $parameterProduk->update($request->only([
            'production_batch_id',
            'sampling_ke',
            'berat_per_3pcs',
            'diameter',
            'panjang',
            'berat_per_pcs',
            'berat_kulit',
            'berat_adonan',
            'berat_per_3pcs_akhir',
        ]));

        return redirect()
            ->route('operator.parameter-produk.detail', $parameterProduk->production_batch_id)
            ->with('success', 'Parameter produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $parameterProduk = ParameterProduk::findOrFail($id);
            $productionBatchId = $parameterProduk->production_batch_id;

            $parameterProduk->delete();

            $remaining = ParameterProduk::where('production_batch_id', $productionBatchId)->count();

            return redirect()
                ->route(
                    $remaining > 0
                        ? 'operator.parameter-produk.detail'
                        : 'operator.parameter-produk.index',
                    $remaining > 0 ? $productionBatchId : []
                )
                ->with('success', 'Parameter produk berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus parameter produk: ' . $e->getMessage());
        }
    }

    public function managerIndex(Request $request)
    {
        $query = ProductionBatch::query()
            ->withCount('parameterProduks')
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
            ->whereHas('parameterProduks')
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('pages.manager.parameter-produk.index', compact('productionBatches'));
    }

    public function managerDetail($productionBatchId)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($productionBatchId);

        $parameterProduks = ParameterProduk::where('production_batch_id', $productionBatch->id)
            ->orderBy('sampling_ke')
            ->get();

        abort_if($parameterProduks->isEmpty(), 404);

        return view(
            'pages.manager.parameter-produk.detail',
            compact('productionBatch', 'parameterProduks')
        );
    }
}