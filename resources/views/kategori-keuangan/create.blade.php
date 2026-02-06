@extends('layouts.dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-7 col-md-9">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Tambah Kategori</h4>
                <p class="text-muted mb-0">
                    Buat kategori baru untuk merapikan catatan keuangan Anda.
                </p>
            </div>
            <a href="{{ route('dashboard.kategori-keuangan.index') }}"
               class="btn btn-light rounded-circle">
                <i class="bx bx-x"></i>
            </a>
        </div>

        {{-- Card --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">

                <form action="{{ route('dashboard.kategori-keuangan.store') }}" method="POST">
                    @csrf

                    {{-- Nama Kategori --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Nama Kategori
                        </label>
                        <input type="text"
                               name="nama_kategori"
                               value="{{ old('nama_kategori') }}"
                               class="form-control form-control-lg @error('nama_kategori') is-invalid @enderror"
                               placeholder="Contoh: Gaji, Makanan, Investasi"
                               required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Tipe --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-3">
                            Tipe Kategori
                        </label>

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="w-100">
                                    <input type="radio"
                                           name="jenis"
                                           value="pemasukan"
                                           class="d-none"
                                           {{ old('jenis','pemasukan') == 'pemasukan' ? 'checked' : '' }}>
                                    <div class="border rounded-3 p-3 text-center radio-card">
                                        <i class="bx bx-trending-up text-success fs-4"></i>
                                        <div class="fw-semibold mt-1">Pemasukan</div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-6">
                                <label class="w-100">
                                    <input type="radio"
                                           name="jenis"
                                           value="pengeluaran"
                                           class="d-none"
                                           {{ old('jenis') == 'pengeluaran' ? 'checked' : '' }}>
                                    <div class="border rounded-3 p-3 text-center radio-card">
                                        <i class="bx bx-trending-down text-danger fs-4"></i>
                                        <div class="fw-semibold mt-1">Pengeluaran</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        @error('jenis')
                            <small class="text-danger d-block mt-2">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    {{-- Action --}}
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary px-4">
                            Simpan Kategori
                        </button>
                        <a href="{{ route('dashboard.kategori-keuangan.index') }}"
                           class="btn btn-light">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<style>
    .radio-card.selected {
        border-color: #007bff !important;
        background-color: #f8f9fa;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radioCards = document.querySelectorAll('.radio-card');

        radioCards.forEach(card => {
            card.addEventListener('click', function() {
                const label = this.closest('label');
                const radio = label.querySelector('input[type="radio"]');
                radio.checked = true;

                // Add visual feedback
                radioCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    });
</script>
@endpush
