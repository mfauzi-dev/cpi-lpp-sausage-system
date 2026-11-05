<?php

namespace App\Http\Controllers;

use App\Exports\LaporanPengendalianProdukSausageExport;
use App\Models\Product;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductionBatchController extends Controller
{
    public function getByDate($date)
    {
        $productionBatches = ProductionBatch::with('product:id,name')
            ->whereDate('tanggal', $date)
            ->latest('id')
            ->get([
                'id',
                'hari',
                'tanggal',
                'product_id',
                'kode_batch',
                'yield_meat',
                'total_meat',
                'shift',
            ]);

        return response()->json($productionBatches);
    }

    public function index(Request $request)
    {
        $query = ProductionBatch::with('product')
            ->latest('tanggal')
            ->latest('id');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('hari')) {
            $query->where('hari', 'like', '%' . $request->hari . '%');
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('kode_batch')) {
            $query->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
        }
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        $productionBatches = $query->paginate(10)->withQueryString();

        return view('pages.operator.production-batch.index', compact('productionBatches'));
    }

    public function managerIndex(Request $request)
    {
        $query = ProductionBatch::with('product')
            ->latest('tanggal')
            ->latest('id');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('hari')) {
            $query->where('hari', 'like', '%' . $request->hari . '%');
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('kode_batch')) {
            $query->where('kode_batch', 'like', '%' . $request->kode_batch . '%');
        }
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        $productionBatches = $query->paginate(10)->withQueryString();

        return view('pages.manager.production-batch.index', compact('productionBatches'));
    }

    public function managerDetail($id)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        return view('pages.manager.production-batch.detail', compact('productionBatch'));
    }

    public function detail($id)
    {
        $productionBatch = ProductionBatch::with('product')->findOrFail($id);

        return view('pages.operator.production-batch.detail', compact('productionBatch'));
    }

    public function create()
    {
        $products = Product::orderBy('id')->get();

        return view('pages.operator.production-batch.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => ['required', 'string', 'max:30'],
            'tanggal' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'kode_batch' => ['required', 'string', 'max:255'],
            'yield_meat' => ['nullable', 'numeric', 'min:0'],
            'total_meat' => ['nullable', 'numeric', 'min:0'],
            'shift' => ['nullable', 'integer', 'min:1', 'max:3'],
        ]);

        DB::beginTransaction();

        try {
            ProductionBatch::create($validated);
            DB::commit();

            return redirect()
                ->route('operator.production-batch.index')
                ->with('success', 'Data production batch berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data production batch.');
        }
    }

    public function edit($id)
    {
        $productionBatch = ProductionBatch::findOrFail($id);
        $products = Product::orderBy('id')->get();

        return view('pages.operator.production-batch.edit', compact('productionBatch', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'hari' => ['required', 'string', 'max:30'],
            'tanggal' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'kode_batch' => ['required', 'string', 'max:255'],
            'yield_meat' => ['nullable', 'numeric', 'min:0'],
            'total_meat' => ['nullable', 'numeric', 'min:0'],
            'shift' => ['nullable', 'integer', 'min:1', 'max:3'],
        ]);

        DB::beginTransaction();

        try {
            $productionBatch = ProductionBatch::findOrFail($id);
            $productionBatch->update($validated);
            DB::commit();

            return redirect()
                ->route('operator.production-batch.index')
                ->with('success', 'Data production batch berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data production batch.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $productionBatch = ProductionBatch::findOrFail($id);
            $productionBatch->delete();
            DB::commit();

            return redirect()
                ->route('operator.production-batch.index')
                ->with('success', 'Data production batch berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return redirect()
                ->route('operator.production-batch.index')
                ->with('error', 'Gagal menghapus data production batch.');
        }
    }

        public function export($id)
    {
        $productionBatch = ProductionBatch::findOrFail($id);

        return Excel::download(
            new LaporanPengendalianProdukSausageExport($productionBatch->id),
            'Laporan-Pengendalian-Produk-Sausage.xlsx'
        );
    }

    public function managerExport($id)
    {
        $productionBatch = ProductionBatch::findOrFail($id);

        return Excel::download(
            new LaporanPengendalianProdukSausageExport($productionBatch->id),
            'Laporan-Pengendalian-Produk-Sausage.xlsx'
        );
    }
}
