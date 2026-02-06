<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\AkunKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $akun_id = $request->get('akun_id');
        $selected_akun = null;
        $akun_keuangan = collect();

        // Jika ada akun yang dipilih, filter berdasarkan akun tersebut
        if ($akun_id) {
            $selected_akun = AkunKeuangan::find($akun_id);

            // Total Pemasukan per akun
            $total_pemasukan = Transaksi::where('jenis', 'pemasukan')
                ->where('akun_id', $akun_id)
                ->sum('jumlah');

            // Total Pengeluaran per akun
            $total_pengeluaran = Transaksi::where('jenis', 'pengeluaran')
                ->where('akun_id', $akun_id)
                ->sum('jumlah');

            // Total Saldo (Pemasukan - Pengeluaran) per akun
            $total_saldo = $total_pemasukan - $total_pengeluaran;

            // Data untuk grafik bulanan per akun
            $grafik_data = Transaksi::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('YEAR(tanggal) as tahun'),
                DB::raw('SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as masuk'),
                DB::raw('SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as keluar')
            )
            ->where('akun_id', $akun_id)
            ->whereYear('tanggal', date('Y'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get()
            ->map(function ($item) {
                $item->bulan = date('M', mktime(0, 0, 0, $item->bulan, 1));
                return $item;
            });

            // Transaksi terakhir (5 terbaru) per akun
            $transactions = Transaksi::with(['kategori', 'akun'])
                ->where('akun_id', $akun_id)
                ->latest()
                ->take(5)
                ->get();
        } else {
            // Total keseluruhan (seperti sebelumnya)
            $total_pemasukan = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
            $total_pengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
            $total_saldo = $total_pemasukan - $total_pengeluaran;

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

            $transactions = Transaksi::with(['kategori', 'akun'])
                ->latest()
                ->take(5)
                ->get();
        }

        // Ambil semua akun untuk dropdown
        $akun_keuangan = auth()->check() ? AkunKeuangan::where('user_id', auth()->id())->get() : collect();

        return view('dashboard.index', compact(
            'total_pemasukan',
            'total_pengeluaran',
            'total_saldo',
            'grafik_data',
            'transactions',
            'akun_keuangan',
            'selected_akun'
        ));
    }
}
