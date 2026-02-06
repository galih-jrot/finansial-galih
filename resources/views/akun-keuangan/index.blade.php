@extends('layouts.dashboard')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn px-3 px-md-4 px-lg-5" style="padding-top: 2rem; padding-bottom: 2rem;">
    {{-- Header & Action Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-4">
                <div>
                    <h2 class="fw-bold text-dark mb-2" style="font-size: 2rem;">Akun & Rekening</h2>
                    <p class="text-muted mb-0">Kelola semua sumber dana dan saldo awal Anda di sini.</p>
                </div>
                <div>
                    <a href="{{ route('dashboard.akun-keuangan.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                        <i class='bx bx-plus me-2'></i>
                        Tambah Akun Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="card border-0 shadow-sm" style="border-radius: 1.5rem;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0" style="letter-spacing: 0.05em;">Nama Akun</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0" style="letter-spacing: 0.05em;">Jenis</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0 text-end" style="letter-spacing: 0.05em;">Saldo Awal</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0 text-center" style="letter-spacing: 0.05em;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($akun as $a)
                        <tr class="table-hover">
                            {{-- Nama Akun --}}
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary" style="width: 40px; height: 40px;">
                                        <i class='bx bx-credit-card-front fs-5'></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $a->nama_akun }}</span>
                                </div>
                            </td>

                            {{-- Jenis --}}
                            <td class="px-4 py-3">
                                <span class="badge {{ $a->jenis == 'bank' ? 'bg-info bg-opacity-10 text-info' : 'bg-success bg-opacity-10 text-success' }} px-3 py-2 rounded-pill">
                                    <i class="bx {{ $a->jenis == 'bank' ? 'bx-building' : 'bx-wallet' }} me-1"></i>
                                    {{ ucfirst($a->jenis) }}
                                </span>
                            </td>

                            {{-- Saldo Awal --}}
                            <td class="px-4 py-3 text-end">
                                <span class="fw-bold text-dark">
                                    Rp {{ number_format($a->saldo_awal, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-3 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('dashboard.akun-keuangan.show', $a->id) }}" title="Lihat Detail" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class='bx bx-show-alt'></i>
                                    </a>
                                    <form action="{{ route('dashboard.akun-keuangan.destroy', $a->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus akun ini?')">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 4rem; height: 4rem;">
                                        <i class='bx bx-credit-card fs-1 text-muted'></i>
                                    </div>
                                    <h6 class="text-dark fw-bold mb-2">Belum Ada Akun</h6>
                                    <p class="text-muted small mb-0">Tambahkan akun pertama untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($akun->hasPages())
            <div class="card-footer bg-white border-0 p-4">
                {{ $akun->links() }}
            </div>
            @endif
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
    nav[role="navigation"] svg { width: 20px; }
</style>
@endsection
