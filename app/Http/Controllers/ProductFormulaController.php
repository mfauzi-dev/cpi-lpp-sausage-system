<?php

namespace App\Http\Controllers;

use App\Imports\FormulaImport;
use App\Models\BahanBaku;
use App\Models\Product;
use App\Models\ProductFormula;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductFormulaController extends Controller
{
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $bahanBakus = BahanBaku::orderBy('name')->get();

        $formulas = $product->formulas()
            ->with('bahanBaku')
            ->orderBy('multiplier')
            ->get()
            ->groupBy('multiplier');

        return view('pages.operator.product.formula', compact('product', 'bahanBakus', 'formulas'));
    }

    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'bahan_baku_id' => ['required', 'exists:bahan_bakus,id'],
            'multiplier' => ['required', 'integer', 'min:1'],
            'qty' => ['required', 'numeric', 'min:0'],
        ]);

        $exists = ProductFormula::where('product_id', $product->id)
            ->where('bahan_baku_id', $request->bahan_baku_id)
            ->where('multiplier', $request->multiplier)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Kombinasi bahan baku + multiplier ini sudah ada.');
        }

        $product->formulas()->create($request->only('bahan_baku_id', 'multiplier', 'qty'));

        return back()->with('success', 'Formula berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $formula = ProductFormula::findOrFail($id);

        $request->validate(['qty' => ['required', 'numeric', 'min:0']]);

        $formula->update(['qty' => $request->qty]);

        return back()->with('success', 'Formula berhasil diupdate.');
    }

    public function destroy($id)
    {
        ProductFormula::findOrFail($id)->delete();

        return back()->with('success', 'Formula berhasil dihapus.');
    }

    public function getBahanBakuByProduct($productId)
    {
        $product = Product::findOrFail($productId);

        $bahanBakus = $product->formulas()
            ->with('bahanBaku')
            ->get()
            ->pluck('bahanBaku')
            ->unique('id')
            ->values();

        return response()->json($bahanBakus);
    }

    public function importPage()
    {
        $products = Product::orderBy('name')->get();

        return view('pages.operator.product.formula-import', compact('products'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        try {
            $file = $request->file('file');

            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheetCount = $spreadsheet->getSheetCount();
            unset($spreadsheet);

            $import = new FormulaImport((int) $request->product_id, $sheetCount);
            Excel::import($import, $file);

            $summary = $import->getSummary();

            return redirect()
                ->route('operator.product.formula.index', $request->product_id)
                ->with('success', "Import selesai: {$summary['blocks']} blok formula, {$summary['imported']} baris tersimpan, {$summary['skipped']} dilewati.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}