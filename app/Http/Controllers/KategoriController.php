<?php

namespace App\Http\Controllers;

use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $title = 'Delete Kategori!';
        $text  = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        $kategoris = KategoriKeuangan::all();
        return view('dashboard.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('dashboard.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|in:pemasukan,pengeluaran',
        ]);

        KategoriKeuangan::create($validated);

        session()->flash("toast_notification", [
            "level"   => "success",
            "message" => "Kategori Successfully Created",
        ]);

        return redirect()->route('dashboard.kategori.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $kategori = KategoriKeuangan::findOrFail($id);
        return view('dashboard.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {
        $kategori  = KategoriKeuangan::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|in:pemasukan,pengeluaran',
        ]);

        $kategori->update($validated);
        session()->flash("toast_notification", [
            "level"   => "success",
            "message" => "Kategori Successfully Edited",
        ]);
        return redirect()->route('dashboard.kategori.index');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriKeuangan::findOrFail($id);
        $kategori->delete();
        session()->flash("toast_notification", [
            "level"   => "success",
            "message" => "Kategori Successfully Deleted",
        ]);
        return redirect()->route('dashboard.kategori.index');
    }
}
