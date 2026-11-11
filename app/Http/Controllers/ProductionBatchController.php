<?php

namespace App\Http\Controllers;

use App\Exports\LaporanPengendalianProdukSausageExport;
use App\Models\Product;
use App\Models\ProductionBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        $request->validate([
            'hari' => ['required', 'string', 'max:30'],
            'tanggal' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'kode_batch' => ['required', 'string', 'max:255'],
            'yield_meat' => ['nullable', 'numeric', 'min:0'],
            'total_meat' => ['nullable', 'numeric', 'min:0'],
            'shift' => ['nullable', 'integer', 'min:1', 'max:3'],
            'foto_kartu_rute' => ['nullable', 'image', 'max:5120'],
            'foto_stamp_plastik' => ['nullable', 'image', 'max:5120'],
            'foto_stamp_box' => ['nullable', 'image', 'max:5120'],
            'foto_ed_plastik' => ['nullable', 'image', 'max:5120'],
            'foto_ed_carton_box' => ['nullable', 'image', 'max:5120'],
        ]);

        $data = $request->only([
            'hari',
            'tanggal',
            'product_id',
            'kode_batch',
            'yield_meat',
            'total_meat',
            'shift',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('foto_kartu_rute')) {
                $data['foto_kartu_rute'] = $request->file('foto_kartu_rute')
                    ->store('production-batches/kartu-rute', 'public');
            }

            if ($request->hasFile('foto_stamp_plastik')) {
                $data['foto_stamp_plastik'] = $request->file('foto_stamp_plastik')
                    ->store('production-batches/stamp-plastik', 'public');
            }

            if ($request->hasFile('foto_stamp_box')) {
                $data['foto_stamp_box'] = $request->file('foto_stamp_box')
                    ->store('production-batches/stamp-box', 'public');
            }

            if ($request->hasFile('foto_ed_plastik')) {
                $data['foto_ed_plastik'] = $request->file('foto_ed_plastik')
                    ->store('production-batches/ed-plastik', 'public');
            }

            if ($request->hasFile('foto_ed_carton_box')) {
                $data['foto_ed_carton_box'] = $request->file('foto_ed_carton_box')
                    ->store('production-batches/ed-carton-box', 'public');
            }

            ProductionBatch::create($data);

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
        $request->validate([
            'hari' => ['required', 'string', 'max:30'],
            'tanggal' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'kode_batch' => ['required', 'string', 'max:255'],
            'yield_meat' => ['nullable', 'numeric', 'min:0'],
            'total_meat' => ['nullable', 'numeric', 'min:0'],
            'shift' => ['nullable', 'integer', 'min:1', 'max:3'],
            'foto_kartu_rute' => ['nullable', 'image', 'max:5120'],
            'foto_stamp_plastik' => ['nullable', 'image', 'max:5120'],
            'foto_stamp_box' => ['nullable', 'image', 'max:5120'],
            'foto_ed_plastik' => ['nullable', 'image', 'max:5120'],
            'foto_ed_carton_box' => ['nullable', 'image', 'max:5120'],
        ]);

        $data = $request->only([
            'hari',
            'tanggal',
            'product_id',
            'kode_batch',
            'yield_meat',
            'total_meat',
            'shift',
        ]);

        DB::beginTransaction();

        try {
            $productionBatch = ProductionBatch::findOrFail($id);

            // Kartu Rute
            if ($request->hasFile('foto_kartu_rute')) {
                if ($productionBatch->foto_kartu_rute) {
                    Storage::disk('public')->delete($productionBatch->foto_kartu_rute);
                }
                $data['foto_kartu_rute'] = $request->file('foto_kartu_rute')
                    ->store('production-batches/kartu-rute', 'public');
            } elseif ($request->boolean('hapus_foto_kartu_rute') && $productionBatch->foto_kartu_rute) {
                Storage::disk('public')->delete($productionBatch->foto_kartu_rute);
                $data['foto_kartu_rute'] = null;
            }

            // Stamp Plastik
            if ($request->hasFile('foto_stamp_plastik')) {
                if ($productionBatch->foto_stamp_plastik) {
                    Storage::disk('public')->delete($productionBatch->foto_stamp_plastik);
                }
                $data['foto_stamp_plastik'] = $request->file('foto_stamp_plastik')
                    ->store('production-batches/stamp-plastik', 'public');
            } elseif ($request->boolean('hapus_foto_stamp_plastik') && $productionBatch->foto_stamp_plastik) {
                Storage::disk('public')->delete($productionBatch->foto_stamp_plastik);
                $data['foto_stamp_plastik'] = null;
            }

            // Stamp Box
            if ($request->hasFile('foto_stamp_box')) {
                if ($productionBatch->foto_stamp_box) {
                    Storage::disk('public')->delete($productionBatch->foto_stamp_box);
                }
                $data['foto_stamp_box'] = $request->file('foto_stamp_box')
                    ->store('production-batches/stamp-box', 'public');
            } elseif ($request->boolean('hapus_foto_stamp_box') && $productionBatch->foto_stamp_box) {
                Storage::disk('public')->delete($productionBatch->foto_stamp_box);
                $data['foto_stamp_box'] = null;
            }

            // ED Plastik
            if ($request->hasFile('foto_ed_plastik')) {
                if ($productionBatch->foto_ed_plastik) {
                    Storage::disk('public')->delete($productionBatch->foto_ed_plastik);
                }
                $data['foto_ed_plastik'] = $request->file('foto_ed_plastik')
                    ->store('production-batches/ed-plastik', 'public');
            } elseif ($request->boolean('hapus_foto_ed_plastik') && $productionBatch->foto_ed_plastik) {
                Storage::disk('public')->delete($productionBatch->foto_ed_plastik);
                $data['foto_ed_plastik'] = null;
            }

            // ED Carton Box
            if ($request->hasFile('foto_ed_carton_box')) {
                if ($productionBatch->foto_ed_carton_box) {
                    Storage::disk('public')->delete($productionBatch->foto_ed_carton_box);
                }
                $data['foto_ed_carton_box'] = $request->file('foto_ed_carton_box')
                    ->store('production-batches/ed-carton-box', 'public');
            } elseif ($request->boolean('hapus_foto_ed_carton_box') && $productionBatch->foto_ed_carton_box) {
                Storage::disk('public')->delete($productionBatch->foto_ed_carton_box);
                $data['foto_ed_carton_box'] = null;
            }

            $productionBatch->update($data);

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

            if ($productionBatch->foto_kartu_rute) {
                Storage::disk('public')->delete($productionBatch->foto_kartu_rute);
            }
            if ($productionBatch->foto_stamp_plastik) {
                Storage::disk('public')->delete($productionBatch->foto_stamp_plastik);
            }
            if ($productionBatch->foto_stamp_box) {
                Storage::disk('public')->delete($productionBatch->foto_stamp_box);
            }
            if ($productionBatch->foto_ed_plastik) {
                Storage::disk('public')->delete($productionBatch->foto_ed_plastik);
            }
            if ($productionBatch->foto_ed_carton_box) {
                Storage::disk('public')->delete($productionBatch->foto_ed_carton_box);
            }

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