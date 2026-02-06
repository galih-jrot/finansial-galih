@extends('layouts.dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-8 col-md-10">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Tambah Akun Baru</h4>
                <p class="text-muted mb-0">
                    Pisahkan sumber dana Anda agar pelacakan lebih akurat.
                </p>
            </div>

            {{-- Tombol Kembali --}}
            <a href="{{ route('dashboard.akun-keuangan.index') }}"
               class="btn btn-light rounded-circle shadow-sm"
               title="Kembali">
                <i class="bx bx-arrow-back"></i>
            </a>
        </div>

        {{-- Card --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">

                <form action="{{ route('dashboard.akun-keuangan.store') }}" method="POST">
                    @csrf

                    {{-- Nama Akun --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Nama Akun / Rekening
                        </label>
                        <input type="text"
                               name="nama_akun"
                               class="form-control form-control-lg"
                               placeholder="Contoh: BCA Personal, Dompet Utama"
                               required>
                    </div>

                    <div class="row g-4">

                        {{-- Jenis Akun --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Jenis Akun
                            </label>
                            <select name="jenis"
                                    class="form-select form-select-lg"
                                    required>
                                <option value="tunai">Tunai (Cash)</option>
                                <option value="bank">Bank (Transfer)</option>
                                <option value="e-wallet">E-Wallet</option>
                            </select>
                        </div>

                        {{-- Saldo Awal --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Saldo Awal
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text fw-bold">Rp</span>
                                <input type="number"
                                       name="saldo_awal"
                                       class="form-control fw-bold text-primary"
                                       placeholder="0"
                                       required>
                            </div>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-5 d-flex gap-3">
                        <button type="submit"
                                class="btn btn-primary btn-lg fw-bold flex-fill">
                            <i class="bx bx-save me-2"></i>
                            Simpan Akun
                        </button>

                        <a href="{{ route('dashboard.akun-keuangan.index') }}"
                           class="btn btn-outline-secondary btn-lg fw-bold flex-fill">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
