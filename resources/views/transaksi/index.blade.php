@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-3 px-md-4 px-lg-5 py-4 animate__animated animate__fadeIn">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4 mb-4">
        <div>
            <h2 class="fw-black text-dark mb-1">Riwayat Transaksi</h2>
            <p class="text-muted mb-0">Pantau seluruh pemasukan dan pengeluaran Anda.</p>
        </div>
        <a href="{{ route('dashboard.transaksi.create') }}"
           class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
            <i class='bx bx-plus me-2'></i>Tambah Transaksi
        </a>
    </div>

    {{-- CARD TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                {{-- HEAD --}}
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-uppercase small text-muted fw-bold">Tanggal</th>
                        <th class="px-4 py-3 text-uppercase small text-muted fw-bold">Transaksi</th>
                        <th class="px-4 py-3 text-uppercase small text-muted fw-bold">Akun</th>
                        <th class="px-4 py-3 text-uppercase small text-muted fw-bold text-end">Jumlah</th>
                        <th class="px-4 py-3 text-uppercase small text-muted fw-bold text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                @forelse ($transaksi as $t)
                    <tr class="border-top">

                        {{-- TANGGAL --}}
                        <td class="px-4 py-3">
                            <div class="fw-bold text-dark">
                                {{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('d M Y') }}
                            </div>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($t->created_at)->format('H:i') }}
                            </small>
                        </td>

                        {{-- INFO --}}
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center
                                    {{ $t->jenis == 'pemasukan'
                                        ? 'bg-success bg-opacity-10 text-success'
                                        : 'bg-danger bg-opacity-10 text-danger' }}"
                                    style="width:42px;height:42px;">
                                    <i class='bx {{ $t->jenis == 'pemasukan' ? 'bx-trending-up' : 'bx-trending-down' }} fs-5'></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">
                                        {{ $t->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                    </div>
                                    <span class="badge rounded-pill
                                        {{ $t->jenis == 'pemasukan' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ ucfirst($t->jenis) }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- AKUN --}}
                        <td class="px-4 py-3">
                            <span class="badge rounded-pill bg-secondary-subtle text-dark px-3 py-2">
                                <i class='bx bx-credit-card me-1'></i>
                                {{ $t->akun->nama_akun ?? '-' }}
                            </span>
                        </td>

                        {{-- JUMLAH --}}
                        <td class="px-4 py-3 text-end">
                            <span class="fw-bold fs-6
                                {{ $t->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                {{ $t->jenis == 'pemasukan' ? '+' : '-' }}
                                Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-3 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('dashboard.transaksi.show', $t->id) }}"
                                   class="btn btn-sm btn-outline-primary rounded-circle"
                                   title="Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                                <form action="{{ route('dashboard.transaksi.destroy', $t->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-circle">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                     style="width:64px;height:64px;">
                                    <i class='bx bx-receipt fs-2 text-muted'></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Belum ada transaksi</h6>
                                <p class="text-muted small mb-0">
                                    Mulai catat pemasukan dan pengeluaran Anda.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($transaksi->hasPages())
        <div class="border-top px-4 py-3 d-flex justify-content-center">
            {{ $transaksi->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .animate__fadeIn {
        animation: fadeIn .6s ease-out;
    }
    @keyframes fadeIn {
        from {opacity:0; transform:translateY(15px);}
        to {opacity:1; transform:translateY(0);}
    }
    nav[role="navigation"] svg {
        width: 18px;
    }
</style>
@endsection
