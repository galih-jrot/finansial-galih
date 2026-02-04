@extends('layouts.app')

@section('content')
<div class="space-y-8 animate__animated animate__fadeIn">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Financial Intelligence</h2>
            <p class="text-sm text-slate-500 font-medium text-decoration-none">Wawasan arus kas dan performa keuangan real-time Anda.</p>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Income Card --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Income</p>
                    <h6 class="text-slate-800 font-bold mb-0">Total Pemasukan</h6>
                </div>
                <div class="bg-emerald-50 text-emerald-600 p-3 rounded-xl">
                    <i class="bx bx-trending-up text-xl"></i>
                </div>
            </div>
            <h3 class="font-black text-emerald-500 mb-0">
                Rp {{ number_format($total_pemasukan, 0, ',', '.') }}
            </h3>
        </div>

        {{-- Expense Card --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Expense</p>
                    <h6 class="text-slate-800 font-bold mb-0">Total Pengeluaran</h6>
                </div>
                <div class="bg-rose-50 text-rose-600 p-3 rounded-xl">
                    <i class="bx bx-trending-down text-xl"></i>
                </div>
            </div>
            <h3 class="font-black text-rose-500 mb-0">
                Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}
            </h3>
        </div>

        {{-- Net Worth Card --}}
        <div class="bg-indigo-50 rounded-[2rem] border border-indigo-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-indigo-600 text-xs font-black uppercase tracking-widest mb-1">Net Worth</p>
                    <h6 class="text-slate-800 font-bold mb-0">Saldo Akhir</h6>
                </div>
                <div class="bg-indigo-600 text-white p-3 rounded-xl shadow-lg">
                    <i class="bx bx-wallet text-xl"></i>
                </div>
            </div>
            <h3 class="font-black text-slate-800 mb-0">
                Rp {{ number_format($total_saldo, 0, ',', '.') }}
            </h3>
        </div>
    </div>

    {{-- Charts and Recent Transactions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- GRAFIK --}}
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <div class="flex justify-between items-center">
                    <h5 class="font-black text-slate-800 mb-0">Grafik Bulanan</h5>
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">Statistik Tahun Ini</span>
                </div>
            </div>
            <div class="p-8">
                <div id="monthlyChart" style="min-height: 320px;"></div>
            </div>
        </div>

        {{-- TRANSAKSI TERAKHIR --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h5 class="font-black text-slate-800 mb-0">Transaksi Terakhir</h5>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($transactions as $t)
                <div class="p-6 hover:bg-slate-50/50 transition-all">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-sm font-bold text-slate-700 mb-1">{{ $t->deskripsi }}</p>
                            <p class="text-xs text-slate-400">
                                {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }} •
                                <span class="{{ $t->jenis == 'pemasukan' ? 'text-emerald-500' : 'text-rose-500' }}">
                                    {{ ucfirst($t->jenis) }}
                                </span>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold {{ $t->jenis == 'pemasukan' ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-16 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 mx-auto text-slate-300">
                        <i class="bx bx-receipt text-2xl"></i>
                    </div>
                    <h4 class="text-slate-800 font-black mb-2">Belum Ada Transaksi</h4>
                    <p class="text-slate-400 text-sm">Mulai catat pengeluaran atau pemasukan Anda.</p>
                </div>
                @endforelse
            </div>
            <div class="p-6 border-t border-slate-50">
                <a href="{{ route('dashboard.transaksi.index') }}" class="inline-flex items-center justify-center w-full px-4 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition-all no-underline">
                    Lihat Semua Transaksi
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .animate__fadeIn {
        animation: fadeIn 0.8s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyData = @json($grafik_data);

    // Ensure we have data, if not, provide default empty data for all months
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const incomeData = new Array(12).fill(0);
    const expenseData = new Array(12).fill(0);

    // Fill data from database
    monthlyData.forEach(item => {
        const monthIndex = months.indexOf(item.bulan);
        if (monthIndex !== -1) {
            incomeData[monthIndex] = parseFloat(item.masuk) || 0;
            expenseData[monthIndex] = parseFloat(item.keluar) || 0;
        }
    });

    new ApexCharts(document.querySelector("#monthlyChart"), {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        series: [
            { name: 'Income', data: incomeData },
            { name: 'Expense', data: expenseData }
        ],
        colors: ['#22c55e', '#ef4444'],
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '50%',
                dataLabels: { position: 'top' }
            }
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 4,
            colors: ['transparent']
        },
        xaxis: {
            categories: months,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
        },
        yaxis: {
            labels: {
                style: { colors: '#94a3b8' },
                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
            }
        },
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4,
            yaxis: { lines: { show: true } }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            fontSize: '13px',
            markers: { radius: 12 }
        },
        tooltip: {
            y: { formatter: val => 'Rp ' + val.toLocaleString('id-ID') }
        }
    }).render();
});
</script>
@endsection
