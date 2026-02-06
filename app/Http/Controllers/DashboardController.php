<?php

namespace App\Http\Controllers;

use App\Models\AkunKeuangan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $akunId = $request->akun_id;

        $akun_keuangan = auth()->check() ? AkunKeuangan::where('user_id', auth()->id())->get() : collect();

        $transaksiQuery = Transaksi::where('user_id', auth()->id());

        if ($akunId) {
            $transaksiQuery->where('akun_id', $akunId);
        }

        $totalPemasukan = (clone $transaksiQuery)
            ->where('jenis', 'pemasukan')
            ->sum('jumlah');

        $totalPengeluaran = (clone $transaksiQuery)
            ->where('jenis', 'pengeluaran')
            ->sum('jumlah');

        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // DATA GRAFIK BULANAN
        $grafik = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafik['pemasukan'][] = (clone $transaksiQuery)
                ->whereMonth('tanggal', $i)
                ->where('jenis', 'pemasukan')
                ->sum('jumlah');

            $grafik['pengeluaran'][] = (clone $transaksiQuery)
                ->whereMonth('tanggal', $i)
                ->where('jenis', 'pengeluaran')
                ->sum('jumlah');
        }

        $transaksiTerakhir = (clone $transaksiQuery)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'akun_keuangan',
            'akunId',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'grafik',
            'transaksiTerakhir'
        ));
    }
}
