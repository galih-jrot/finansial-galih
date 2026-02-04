<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\KategoriKeuangan;
use App\Models\AkunKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['kategori', 'akun'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->get();
        $akun = AkunKeuangan::where('user_id', Auth::id())->get();

        return view('transaksi.create', compact('kategori', 'akun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori_keuangan_id' => 'required|exists:kategori_keuangan,id',
            'akun_keuangan_id' => 'required|exists:akun_keuangan,id',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Transaksi::create([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori_id' => $request->kategori_keuangan_id,
            'akun_id' => $request->akun_keuangan_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaksi $transaksi)
    {
        // Ensure user can only view their own transactions
        if ($transaksi->user_id !== Auth::id()) {
            abort(403);
        }

        $transaksi->load(['kategori', 'akun', 'user']);

        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        // Ensure user can only edit their own transactions
        if ($transaksi->user_id !== Auth::id()) {
            abort(403);
        }

        $kategori = KategoriKeuangan::where('user_id', Auth::id())->get();
        $akun = AkunKeuangan::where('user_id', Auth::id())->get();

        return view('transaksi.edit', compact('transaksi', 'kategori', 'akun'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        // Ensure user can only update their own transactions
        if ($transaksi->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori_keuangan_id' => 'required|exists:kategori_keuangans,id',
            'akun_keuangan_id' => 'required|exists:akun_keuangans,id',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $transaksi->update([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori_id' => $request->kategori_keuangan_id,
            'akun_id' => $request->akun_keuangan_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dashboard.transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Ensure user can only delete their own transactions
        if ($transaksi->user_id !== Auth::id()) {
            abort(403);
        }

        $transaksi->delete();

        return redirect()->route('dashboard.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
