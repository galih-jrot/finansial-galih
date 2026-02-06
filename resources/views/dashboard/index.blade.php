@extends('layouts.dashboard')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn px-3 px-md-4 px-lg-5" style="padding-top: 2rem; padding-bottom: 2rem;">
    {{-- Header --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-4">
                <div>
                    <h2 class="fw-bold text-dark mb-2" style="font-size: 2.25rem;">Financial Intelligence</h2>
                    <p class="text-muted mb-0" style="font-size: 0.95rem;">Wawasan arus kas dan performa keuangan real-time Anda.</p>
                </div>
                {{-- Account Selector --}}
                <div class="d-flex align-items-center gap-3">
                    <label for="akun_selector" class="text-muted fw-bold mb-0" style="font-size: 0.9rem;">Pilih Akun:</label>
                    <form method="GET" action="{{ route('dashboard.index') }}">
                        <select name="akun_id"
                                class="form-select"
                                onchange="this.form.submit()">
                            <option value="">Semua Akun</option>
                            @foreach ($akun_keuangan as $akun)
                                <option value="{{ $akun->id }}"
                                    {{ $akunId == $akun->id ? 'selected' : '' }}>
                                    {{ $akun->nama_akun }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row g-4 mb-5">
        {{-- Income Card --}}
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1.5rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 0.1em;">Income</p>
                            <h6 class="text-dark fw-bold mb-0">Total Pemasukan</h6>
                        </div>
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                            <i class="bx bx-trending-up fs-4"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-success mb-0">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- Expense Card --}}
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1.5rem;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 0.1em;">Expense</p>
                            <h6 class="text-dark fw-bold mb-0">Total Pengeluaran</h6>
                        </div>
                        <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3">
                            <i class="bx bx-trending-down fs-4"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-danger mb-0">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- Net Worth Card --}}
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1.5rem; background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <p class="text-primary small fw-bold text-uppercase mb-1" style="letter-spacing: 0.1em;">Net Worth</p>
                            <h6 class="text-dark fw-bold mb-0">Saldo Akhir</h6>
                        </div>
                        <div class="bg-primary text-white p-3 rounded-3 shadow">
                            <i class="bx bx-wallet fs-4"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-0">
                        Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts and Recent Transactions --}}
    <div class="row g-4">
        {{-- GRAFIK --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 1.5rem;">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">Grafik Bulanan</h5>
                        <span class="badge bg-light text-muted px-3 py-2 rounded-pill">Statistik Tahun Ini</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="monthlyChart" style="min-height: 320px;"></div>
                </div>
            </div>
        </div>

        {{-- TRANSAKSI TERAKHIR --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 1.5rem;">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold text-dark mb-0">Transaksi Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($transaksiTerakhir as $t)
                        <div class="list-group-item border-0 px-4 py-3 hover-bg-light transition-all">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <p class="fw-bold text-dark mb-1 small">{{ $t->keterangan }}</p>
                                    <p class="text-muted small mb-0">
                                        {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }} •
                                        <span class="{{ $t->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                            {{ ucfirst($t->jenis) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold {{ $t->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }} small">
                                        {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center p-5">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 4rem; height: 4rem;">
                                <i class="bx bx-receipt text-muted fs-1"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-2">Belum Ada Transaksi</h6>
                            <p class="text-muted small">Mulai catat pengeluaran atau pemasukan Anda.</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="card-footer bg-white border-0 p-4">
                        <a href="{{ route('dashboard.transaksi.index') }}" class="btn btn-outline-primary w-100 rounded-pill fw-bold">
                            Lihat Semua Transaksi
                        </a>
                    </div>
                </div>
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
var options = {
    chart: {
        type: 'bar',
        height: 300
    },
    series: [
        {
            name: 'Pemasukan',
            data: @json($grafik['pemasukan'])
        },
        {
            name: 'Pengeluaran',
            data: @json($grafik['pengeluaran'])
        }
    ],
    xaxis: {
        categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']
    }
};

new ApexCharts(document.querySelector("#monthlyChart"), options).render();
</script>
@endsection
