<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriKeuanganController extends Controller
{
    public function index()
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('kategori-keuangan.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori-keuangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_keuangan,nama_kategori,NULL,id,user_id,' . Auth::id(),
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        KategoriKeuangan::create([
            'nama_kategori' => $request->nama_kategori,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard.kategori-keuangan.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(KategoriKeuangan $kategoriKeuangan)
    {
        if ($kategoriKeuangan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('kategori-keuangan.show', compact('kategoriKeuangan'));
    }

    public function edit(KategoriKeuangan $kategoriKeuangan)
    {
        if ($kategoriKeuangan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('kategori-keuangan.edit', compact('kategoriKeuangan'));
    }

    public function update(Request $request, KategoriKeuangan $kategoriKeuangan)
    {
        if ($kategoriKeuangan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_keuangan,nama_kategori,' . $kategoriKeuangan->id . ',id,user_id,' . Auth::id(),
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $kategoriKeuangan->update([
            'nama_kategori' => $request->nama_kategori,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('dashboard.kategori-keuangan.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriKeuangan $kategoriKeuangan)
    {
        if ($kategoriKeuangan->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if kategori is being used in transactions
        if ($kategoriKeuangan->transaksi()->exists()) {
            return redirect()->route('dashboard.kategori-keuangan.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan dalam transaksi.');
        }

        $kategoriKeuangan->delete();

        return redirect()->route('dashboard.kategori-keuangan.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
