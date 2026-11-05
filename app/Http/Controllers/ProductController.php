<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string'],
            'size' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = Product::withCount('formulas');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $products = $query->orderBy('name')
            ->paginate($request->size ?? 20)
            ->withQueryString();

        return view('pages.operator.product.index', [
            'products' => $products,
            'search' => $request->search,
        ]);
    }

    public function create()
    {
        return view('pages.operator.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
        ]);

        $product = Product::create(['name' => $request->name]);

        return redirect()
            ->route('operator.product.formula.index', $product->id)
            ->with('success', 'Produk berhasil ditambahkan, lanjut isi formula.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('pages.operator.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' . $product->id],
        ]);

        $product->update(['name' => $request->name]);

        return redirect()
            ->route('operator.product.index')
            ->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()
            ->route('operator.product.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:products,id'],
        ]);

        Product::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('operator.product.index')
            ->with('success', 'Produk terpilih berhasil dihapus.');
    }

    public function importPage()
    {
        return view('pages.operator.product.import');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        try {
            Excel::import(new ProductImport, $request->file('file'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('operator.product.index')
            ->with('success', 'Data produk berhasil diimport.');
    }
}