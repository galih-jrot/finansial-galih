@extends('layouts.dashboard')

@section('content')
<div class="row">
  <div class="col-12">

    {{-- HEADER --}}
    <div class="mb-4">
      <h4 class="fw-bold mb-1">Tambah Transaksi</h4>
      <p class="text-muted mb-2">
        Catat arus kas masuk atau keluar secara akurat
      </p>
      <a href="{{ route('dashboard.transaksi.index') }}"
         class="text-primary fw-semibold">
        ← Kembali
      </a>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- CARD --}}
    <div class="card">
      <div class="card-body">

        <form action="{{ route('dashboard.transaksi.store') }}" method="POST">
          @csrf

          <div class="row g-3">

            {{-- TANGGAL --}}
            <div class="col-md-6">
              <label class="form-label">Tanggal Transaksi</label>
              <input type="date"
                     name="tanggal"
                     value="{{ old('tanggal', date('Y-m-d')) }}"
                     class="form-control"
                     required>
            </div>

            {{-- JENIS --}}
            <div class="col-md-6">
              <label class="form-label">Jenis Arus Kas</label>
              <select name="jenis" class="form-select" required>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
              </select>
            </div>

            {{-- KATEGORI --}}
            <div class="col-md-6">
              <label class="form-label">Kategori</label>
              <select name="kategori_keuangan_id" class="form-select" required>
                <option value="">Pilih Kategori</option>
                @foreach ($kategori as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                @endforeach
              </select>
            </div>

            {{-- AKUN --}}
            <div class="col-md-6">
              <label class="form-label">Akun</label>
              <select name="akun_keuangan_id" class="form-select" required>
                <option value="">Pilih Akun</option>
                @foreach ($akun as $a)
                  <option value="{{ $a->id }}">{{ $a->nama_akun }}</option>
                @endforeach
              </select>
            </div>

            {{-- JUMLAH --}}
            <div class="col-12">
              <label class="form-label">Nominal (Rp)</label>
              <input type="number"
                     name="jumlah"
                     class="form-control"
                     placeholder="0"
                     required>
            </div>

            {{-- KETERANGAN --}}
            <div class="col-12">
              <label class="form-label">Keterangan</label>
              <textarea name="keterangan"
                        rows="3"
                        class="form-control"
                        placeholder="Contoh: Beli kopi..."></textarea>
            </div>

          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary">
              Simpan Transaksi
            </button>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>
@endsection
