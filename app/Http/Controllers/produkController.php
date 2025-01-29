<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|string|max:255',
        ]);

        Produk::create($request->all());
        return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
    }

    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|string|max:255',
        ]);

        $produk->update($request->all());
        return redirect()->route('produk.index')->with('success', 'Produk updated successfully.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $produk = Produk::where('nama_produk', 'LIKE', "%{$query}%")
            ->orWhere('harga_produk', 'LIKE', "%{$query}%")
            ->get();
        
        return response()->json($produk);
    }
}
