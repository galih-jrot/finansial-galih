<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $total_pengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $total_pemasukan   = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $total_saldo       = $total_pemasukan - $total_pengeluaran;

        // Recent transactions
        $transactions = Transaksi::with('kategori')->latest()->take(5)->get();

        // Monthly cash flow data for chart
        $grafik_data = Transaksi::selectRaw('
            YEAR(tanggal) as tahun,
            MONTH(tanggal) as bulan,
            SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as masuk,
            SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as keluar
        ')
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->take(12)
        ->get()
        ->map(function ($item) {
            return [
                'bulan' => date('M Y', mktime(0, 0, 0, $item->bulan, 1, $item->tahun)),
                'masuk' => $item->masuk,
                'keluar' => $item->keluar,
            ];
        });

        return view('dashboard.index', compact(
            'total_pengeluaran',
            'total_pemasukan',
            'total_saldo',
            'transactions',
            'grafik_data'
        ));
    }
}
