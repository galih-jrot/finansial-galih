@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Data Kategori Keuangan
                    <a href="{{ route('dashboard.kategori.create') }}" class="btn btn-primary btn-sm float-end">
                        Add Kategori
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="kategori-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Tipe</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategoris as $kategori)
                                <tr>
                                    <td>{{ $kategori->id }}</td>
                                    <td>{{ $kategori->nama }}</td>
                                    <td>{{ $kategori->tipe }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.kategori.edit', $kategori->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('dashboard.kategori.destroy', $kategori->id) }}"
                                          class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.bootstrap5.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function () {
            $('#kategori-table').DataTable();
        });
</script>
@endpush
