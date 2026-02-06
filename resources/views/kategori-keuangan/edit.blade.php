@extends('layouts.dashboard')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid px-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Edit Kategori</h3>
        <p class="text-muted mb-0">Edit kategori keuangan Anda.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">

            {{-- CARD --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <form action="{{ route('dashboard.kategori-keuangan.update', $kategoriKeuangan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- NAMA KATEGORI --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text"
                                   name="nama_kategori"
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   value="{{ old('nama_kategori', $kategoriKeuangan->nama_kategori) }}"
                                   placeholder="Contoh: Gaji, Makanan"
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- JENIS --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tipe Kategori</label>
                            <div class="d-flex gap-4">

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="jenis"
                                           value="pemasukan"
                                           {{ old('jenis', $kategoriKeuangan->jenis) === 'pemasukan' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Pemasukan
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="jenis"
                                           value="pengeluaran"
                                           {{ old('jenis', $kategoriKeuangan->jenis) === 'pengeluaran' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Pengeluaran
                                    </label>
                                </div>

                            </div>
                            @error('jenis')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi"
                                      rows="3"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      placeholder="Deskripsi kategori (opsional)">{{ old('deskripsi', $kategoriKeuangan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                Update
                            </button>
                            <a href="{{ route('dashboard.kategori-keuangan.index') }}"
                               class="btn btn-light w-100">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
