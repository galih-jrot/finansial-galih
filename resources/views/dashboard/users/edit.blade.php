@extends('layouts.dashboard')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn px-3 px-md-4 px-lg-5" style="padding-top: 2rem; padding-bottom: 2rem;">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-4">
                <div>
                    <h2 class="fw-bold text-dark mb-2" style="font-size: 2rem;">Edit Pengguna</h2>
                    <p class="text-muted mb-0">Ubah informasi dan akses pengguna sistem.</p>
                </div>
                <div>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold">
                        <i class='bx bx-arrow-back me-2'></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 1.5rem;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Name Field --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-dark mb-3">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg rounded-pill @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}"
                                   placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email Field --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-dark mb-3">Email</label>
                            <input type="email" class="form-control form-control-lg rounded-pill @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}"
                                   placeholder="Masukkan alamat email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role Field --}}
                        <div class="mb-4">
                            <label for="role" class="form-label fw-bold text-dark mb-3">Role Pengguna</label>
                            <select class="form-select form-select-lg rounded-pill @error('role') is-invalid @enderror"
                                    id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    <i class="bx bx-shield-check me-2"></i>Administrator
                                </option>
                                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>
                                    <i class="bx bx-user-check me-2"></i>Petugas
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Field --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-dark mb-3">Password Baru (Opsional)</label>
                            <input type="password" class="form-control form-control-lg rounded-pill @error('password') is-invalid @enderror"
                                   id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <div class="form-text text-muted mt-2">
                                <i class="bx bx-info-circle me-1"></i>
                                Kosongkan field ini jika tidak ingin mengubah password
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-3 justify-content-end mt-5">
                            <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold">
                                <i class='bx bx-x me-2'></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                                <i class='bx bx-save me-2'></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
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
@endsection
