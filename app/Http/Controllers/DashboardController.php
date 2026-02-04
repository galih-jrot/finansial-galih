<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Pemasukan
        $total_pemasukan = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');

        // Total Pengeluaran
        $total_pengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');

        // Total Saldo (Pemasukan - Pengeluaran)
        $total_saldo = $total_pemasukan - $total_pengeluaran;

        // Data untuk grafik bulanan
        $grafik_data = Transaksi::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as masuk'),
            DB::raw('SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as keluar')
        )
        ->whereYear('tanggal', date('Y'))
        ->groupBy('tahun', 'bulan')
        ->orderBy('bulan')
        ->get()
        ->map(function ($item) {
            $item->bulan = date('M', mktime(0, 0, 0, $item->bulan, 1));
            return $item;
        });

        // Transaksi terakhir (5 terbaru)
        $transactions = Transaksi::with(['kategori', 'akun'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'total_pemasukan',
            'total_pengeluaran',
            'total_saldo',
            'grafik_data',
            'transactions'
        ));
    }
}
