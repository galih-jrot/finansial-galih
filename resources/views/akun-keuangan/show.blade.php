@extends('layouts.dashboard')

@section('title', 'Detail Akun')

@section('content')

<div class="row justify-content-center">

    {{-- KEMBALI --}}
    <div class="col-12 col-xl-10 mb-4">
        <a href="{{ route('dashboard.akun-keuangan.index') }}"
           class="fw-semibold text-muted text-decoration-none d-inline-flex align-items-center gap-2">
            <i class="bx bx-arrow-back fs-4"></i>
            Kembali ke Daftar Akun
        </a>
    </div>

    {{-- CARD UTAMA --}}
    <div class="col-12 col-xl-10">
        <div class="card border-0 shadow-sm">

            {{-- HEADER --}}
            <div class="card-body d-flex align-items-center gap-4 border-bottom py-4">
                <div class="avatar avatar-lg bg-label-primary">
                    <i class="bx bx-credit-card-front fs-3"></i>
                </div>

                <div>
                    <h4 class="fw-bold mb-1">
                        {{ $akunKeuangan->nama_akun }}
                    </h4>
                    <span class="badge bg-label-primary text-uppercase">
                        {{ ucfirst($akunKeuangan->jenis) }}
                    </span>
                </div>
            </div>

            {{-- BODY --}}
            <div class="card-body py-5">
                <div class="row g-4">

                    {{-- SALDO --}}
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded">
                            <small class="text-muted fw-semibold text-uppercase">
                                Total Saldo
                            </small>
                            <h3 class="fw-bold mt-2 mb-0">
                                Rp {{ number_format($akunKeuangan->saldo_awal, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded">
                            <small class="text-muted fw-semibold text-uppercase">
                                Informasi
                            </small>
                            <p class="fw-semibold mt-2 mb-0">
                                Dibuat pada {{ $akunKeuangan->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection
