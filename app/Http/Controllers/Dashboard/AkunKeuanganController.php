<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AkunKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunKeuanganController extends Controller
{
    public function index()
    {
        $akun = AkunKeuangan::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('akun-keuangan.index', compact('akun'));
    }

    public function create()
    {
        return view('akun-keuangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_akun' => 'required|string|max:255|unique:akun_keuangan,nama_akun,NULL,id,user_id,' . Auth::id(),
            'jenis' => 'required|in:tunai,bank,e-wallet',
            'saldo_awal' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:500',
        ]);

       AkunKeuangan::create([
    'nama_akun'  => $request->nama_akun,
    'jenis'      => $request->jenis,
    'saldo_awal' => $request->saldo_awal,
    'deskripsi'  => $request->deskripsi,
    'user_id'    => Auth::id(),
]);
        

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Akun keuangan berhasil ditambahkan.');
    }

    public function show(AkunKeuangan $akunKeuangan)
    {
        if ($akunKeuangan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('akun-keuangan.show', compact('akunKeuangan'));
    }

    public function edit(AkunKeuangan $akunKeuangan)
    {
        if ($akunKeuangan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('akun-keuangan.edit', compact('akunKeuangan'));
    }

    public function update(Request $request, AkunKeuangan $akunKeuangan)
    {
        if ($akunKeuangan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nama_akun' => 'required|string|max:255|unique:akun_keuangan,nama_akun,' . $akunKeuangan->id . ',id,user_id,' . Auth::id(),
            'jenis' => 'required|in:tunai,bank,e-wallet',
            'saldo_awal' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $akunKeuangan->update([
            'nama_akun' => $request->nama_akun,
            'jenis' => $request->jenis,
            'saldo_awal' => $request->saldo_awal,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Akun keuangan berhasil diperbarui.');
    }

    public function destroy(AkunKeuangan $akunKeuangan)
    {
        if ($akunKeuangan->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if akun is being used in transactions
        if ($akunKeuangan->transaksi()->exists()) {
            return redirect()->route('dashboard.akun-keuangan.index')
                ->with('error', 'Akun tidak dapat dihapus karena masih digunakan dalam transaksi.');
        }

        $akunKeuangan->delete();

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Akun keuangan berhasil dihapus.');
    }
}
