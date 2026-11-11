<?php

namespace App\Http\Controllers;

use App\Imports\StandarParameterProdukImport;
use App\Models\Product;
use App\Models\StandarParameterProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StandarParameterProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->withCount('standarParameterProduks');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $products = $query
            ->whereHas('standarParameterProduks')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('pages.operator.standar-parameter-produk.index', compact('products'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('pages.operator.standar-parameter-produk.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
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
                        'product_id' => $request->product_id,
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

    public function importPage()
    {
        $products = Product::orderBy('name')->get();

        return view('pages.operator.standar-parameter-produk.import', compact('products'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        try {
            $import = new StandarParameterProdukImport((int) $request->product_id);

            Excel::import($import, $request->file('file'));

            $summary = $import->getSummary();

            return redirect()
                ->route('operator.standar-parameter-produk.detail', $request->product_id)
                ->with('success', "Import selesai: {$summary['imported']} baris sampling tersimpan, {$summary['skipped']} dilewati.");
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function detail($productId)
    {
        $product = Product::findOrFail($productId);

        $standarParameterProduks = StandarParameterProduk::where('product_id', $product->id)
            ->orderBy('sampling_ke')
            ->get();

        abort_if($standarParameterProduks->isEmpty(), 404);

        return view(
            'pages.operator.standar-parameter-produk.detail',
            compact('product', 'standarParameterProduks')
        );
    }

    public function edit($id)
    {
        $standarParameterProduk = StandarParameterProduk::findOrFail($id);

        $products = Product::orderBy('name')->get();

        return view(
            'pages.operator.standar-parameter-produk.edit',
            compact('standarParameterProduk', 'products')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'sampling_ke' => ['required', 'integer', 'min:1'],
            'diameter' => ['nullable', 'numeric', 'min:0'],
            'panjang' => ['nullable', 'numeric', 'min:0'],
            'berat_per_pcs' => ['nullable', 'numeric', 'min:0'],
            'berat_kulit' => ['nullable', 'numeric', 'min:0'],
            'berat_adonan' => ['nullable', 'numeric', 'min:0'],
        ]);

        $standarParameterProduk = StandarParameterProduk::findOrFail($id);

        $standarParameterProduk->update($request->only([
            'product_id',
            'sampling_ke',
            'diameter',
            'panjang',
            'berat_per_pcs',
            'berat_kulit',
            'berat_adonan',
        ]));

        return redirect()
            ->route('operator.standar-parameter-produk.detail', $standarParameterProduk->product_id)
            ->with('success', 'Standar parameter produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $standarParameterProduk = StandarParameterProduk::findOrFail($id);
            $productId = $standarParameterProduk->product_id;

            $standarParameterProduk->delete();

            $remaining = StandarParameterProduk::where('product_id', $productId)->count();

            return redirect()
                ->route(
                    $remaining > 0
                        ? 'operator.standar-parameter-produk.detail'
                        : 'operator.standar-parameter-produk.index',
                    $remaining > 0 ? $productId : []
                )
                ->with('success', 'Standar parameter produk berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus standar parameter produk: ' . $e->getMessage());
        }
    }

    public function managerIndex(Request $request)
    {
        $query = Product::query()->withCount('standarParameterProduks');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $products = $query
            ->whereHas('standarParameterProduks')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('pages.manager.standar-parameter-produk.index', compact('products'));
    }

    public function managerDetail($productId)
    {
        $product = Product::findOrFail($productId);

        $standarParameterProduks = StandarParameterProduk::where('product_id', $product->id)
            ->orderBy('sampling_ke')
            ->get();

        abort_if($standarParameterProduks->isEmpty(), 404);

        return view(
            'pages.manager.standar-parameter-produk.detail',
            compact('product', 'standarParameterProduks')
        );
    }
}