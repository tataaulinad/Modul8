
@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">

        <a href="{{ route('buku.index') }}"
            class="text-decoration-none small">
            Kembali ke daftar buku
        </a>

        <h4 class="mt-3 mb-4">Tambah Buku</h4>

        <div class="card">
            <div class="card-body p-4">

                <form action="{{ route('buku.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul"
                            value="{{ old('judul') }}"
                            class="form-control @error('judul') is-invalid @enderror">

                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis"
                            value="{{ old('penulis') }}"
                            class="form-control @error('penulis') is-invalid @enderror">

                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit"
                            value="{{ old('penerbit') }}"
                            class="form-control @error('penerbit') is-invalid @enderror">

                        @error('penerbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit"
                            value="{{ old('tahun_terbit') }}"
                            class="form-control @error('tahun_terbit') is-invalid @enderror">

                        @error('tahun_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok"
                            value="{{ old('stok', 0) }}"
                            class="form-control @error('stok') is-invalid @enderror">

                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('buku.index') }}"
                            class="btn btn-light">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
