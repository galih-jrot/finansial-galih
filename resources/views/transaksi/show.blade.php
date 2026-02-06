@extends('layouts.dashboard')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid px-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Detail Transaksi</h3>
        <p class="text-muted mb-2">
            Informasi lengkap mengenai riwayat arus kas Anda.
        </p>
        <a href="{{ route('dashboard.transaksi.index') }}" class="text-decoration-none">
            ← Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">

            {{-- CARD --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    {{-- ITEM --}}
                    <div class="d-flex justify-content-between py-3 border-bottom">
                        <span class="text-muted">Tanggal Transaksi</span>
                        <span class="fw-semibold">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d F Y') }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-3 border-bottom">
                        <span class="text-muted">Jenis Arus Kas</span>
                        <span class="badge bg-{{ $transaksi->jenis === 'pemasukan' ? 'success' : 'danger' }}">
                            {{ ucfirst($transaksi->jenis) }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-3 border-bottom">
                        <span class="text-muted">Kategori</span>
                        <span class="fw-semibold">
                            {{ $transaksi->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-3 border-bottom">
                        <span class="text-muted">Sumber Akun / Rekening</span>
                        <span class="fw-semibold">
                            {{ $transaksi->akun->nama_akun ?? 'Tanpa Akun' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between py-3 border-bottom">
                        <span class="text-muted">Nominal</span>
                        <span class="fw-bold text-primary fs-5">
                            Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="pt-3">
                        <span class="text-muted d-block mb-2">Keterangan / Catatan</span>
                        <div class="bg-light rounded p-3">
                            {{ $transaksi->keterangan ?? 'Tidak ada catatan.' }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('dashboard.transaksi.index') }}"
                           class="btn btn-light w-100">
                            Tutup
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
