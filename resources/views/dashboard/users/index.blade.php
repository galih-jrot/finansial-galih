@extends('layouts.dashboard')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn" style="padding: 2rem;">
    {{-- Header & Action Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-4">
                <div>
                    <h2 class="fw-bold text-dark mb-2" style="font-size: 2rem;">Manajemen Pengguna</h2>
                    <p class="text-muted mb-0">Kelola akses dan informasi akun pengguna sistem.</p>
                </div>
                <div>
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                        <i class='bx bx-plus me-2'></i>
                        Tambah User
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
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0" style="letter-spacing: 0.05em;">ID</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0" style="letter-spacing: 0.05em;">User Info</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0" style="letter-spacing: 0.05em;">Role</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0 text-center" style="letter-spacing: 0.05em;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-muted small">#{{ $user->id }}</td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold text-dark" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="fw-bold text-dark mb-0 small">{{ $user->name }}</p>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->role === 'admin')
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                        <i class="bx bx-shield-check me-1"></i>Admin
                                    </span>
                                @elseif($user->role === 'user')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                        <i class="bx bx-user me-1"></i>User
                                    </span>
                                @elseif($user->role === 'petugas')
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                        <i class="bx bx-user-check me-1"></i>Petugas
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                        <i class="bx bx-question-circle me-1"></i>Unknown
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="Edit">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    {{-- Proteksi agar Admin pertama tidak bisa dihapus --}}
                                    @if(!($loop->first && $user->role === 'admin'))
                                        <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus user ini?')" title="Hapus">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 4rem; height: 4rem;">
                                        <i class='bx bx-user text-muted fs-1'></i>
                                    </div>
                                    <h6 class="text-dark fw-bold mb-2">Belum Ada User</h6>
                                    <p class="text-muted small mb-0">Tambahkan user pertama untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($users->hasPages())
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-center py-3">
                                {{ $users->links() }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
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
