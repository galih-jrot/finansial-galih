@extends('layouts.dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
:root {
    --font-main: 'Plus Jakarta Sans', sans-serif;
    --bg-soft: #ffffff;
    --primary: #6366f1;
    --success: #10b981;
    --danger: #ef4444;
}

body {
    font-family: var(--font-main);
    background: var(--bg-soft);
}

/* ===== STAT CARD ===== */
.stat-card {
    border: none;
    border-radius: 24px;
    transition: all .35s ease;
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
}

.bg-expense {
    background: linear-gradient(135deg, #fde2e2, #fecaca);
    color: #7f1d1d;
}

.bg-income {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #065f46;
}

.bg-balance {
    background: linear-gradient(135deg, #6366f1, #4338ca);
    color: #fff;
}

.glass-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: rgba(255,255,255,.25);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ===== CARD SOFT ===== */
.card-soft {
    background: #fff;
    border: none;
    border-radius: 24px;
    box-shadow: 0 12px 30px rgba(0,0,0,.04);
}

/* ===== AKSI CEPAT ===== */
.action-btn {
    border-radius: 20px;
    padding: 18px;
    border: none;
    text-align: left;
    transition: .3s ease;
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(0,0,0,.06);
}

.action-income {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    color: #065f46;
}

.action-expense {
    background: linear-gradient(135deg, #fff1f2, #ffe4e6);
    color: #7f1d1d;
}

.action-report {
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    color: #312e81;
}

/* ===== TABLE ===== */
.custom-table {
    border-collapse: separate;
    border-spacing: 0 12px;
}

.custom-table tr {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 6px 18px rgba(0,0,0,.04);
}

.custom-table td {
    border: none;
    padding: 16px;
}
</style>

<div class="container-xxl container-p-y">

    {{-- ===== STAT ===== --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="stat-card bg-expense p-4" data-aos="fade-up">
                <div class="glass-icon mb-3"><i class="bx bx-trending-down fs-3"></i></div>
                <p class="opacity-75 mb-1">Pengeluaran Bulan Ini</p>
                <h3 class="fw-semibold mb-0">
                    Rp {{ number_format($total_pengeluaran ?? 0,0,',','.') }}
                </h3>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-card bg-income p-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-icon mb-3"><i class="bx bx-trending-up fs-3"></i></div>
                <p class="opacity-75 mb-1">Pemasukan Bulan Ini</p>
                <h3 class="fw-semibold mb-0">
                    Rp {{ number_format($total_pemasukan ?? 0,0,',','.') }}
                </h3>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-card bg-balance p-4" data-aos="fade-up" data-aos-delay="200">
                <span class="badge bg-white text-primary rounded-pill mb-3">OVERVIEW</span>
                <div class="glass-icon mb-3"><i class="bx bx-wallet fs-3"></i></div>
                <p class="opacity-75 mb-1">Saldo Saat Ini</p>
                <h2 class="fw-bold display-6 mb-0">
                    Rp {{ number_format(($total_pemasukan ?? 0)-($total_pengeluaran ?? 0),0,',','.') }}
                </h2>
            </div>
        </div>
    </div>

    {{-- ===== CHART + ACTION ===== --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8" data-aos="fade-right">
            <div class="card-soft p-4 h-100">
                <h5 class="fw-semibold mb-4">Ringkasan Arus Kas Bulanan</h5>
                <div style="height:300px">
                    <canvas id="cashFlowChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4" data-aos="fade-left">
            <div class="card-soft p-4 h-100">
                <h5 class="fw-semibold mb-4">Aksi Cepat</h5>

                <div class="d-grid gap-3">
                    <button class="action-btn action-income">
                        <b>Tambah Pemasukan</b><br>
                        <small>Catat pemasukan baru</small>
                    </button>

                    <button class="action-btn action-expense">
                        <b>Tambah Pengeluaran</b><br>
                        <small>Catat pengeluaran baru</small>
                    </button>

                    <button class="action-btn action-report">
                        <b>Unduh Laporan</b><br>
                        <small>PDF / Excel</small>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TRANSAKSI ===== --}}
    <div class="card-soft p-4" data-aos="fade-up">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="fw-semibold mb-0">Aktivitas Terakhir</h5>
            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Lihat Riwayat</a>
        </div>

        <div class="table-responsive">
            <table class="table custom-table">
                <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td>
                            <b>{{ $trx->keterangan }}</b><br>
                            <small class="text-muted text-capitalize">{{ $trx->jenis }}</small>
                        </td>
                        <td>{{ $trx->tanggal->format('d M Y') }}</td>
                        <td class="text-end fw-bold {{ $trx->jenis=='pemasukan'?'text-success':'text-danger' }}">
                            {{ $trx->jenis=='pemasukan' ? '+' : '-' }}
                            Rp {{ number_format($trx->jumlah,0,',','.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            Belum ada aktivitas keuangan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true });

const ctx = document.getElementById('cashFlowChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($grafik_data->pluck('bulan')) !!},
        datasets: [
            {
                label: 'Pemasukan',
                data: {!! json_encode($grafik_data->pluck('masuk')) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,.12)',
                tension: .4,
                fill: true,
                borderWidth: 3
            },
            {
                label: 'Pengeluaran',
                data: {!! json_encode($grafik_data->pluck('keluar')) !!},
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239,68,68,.12)',
                tension: .4,
                fill: true,
                borderWidth: 3
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { usePointStyle: true, padding: 20 }
            }
        },
        scales: {
            y: { beginAtZero: true },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endsection
