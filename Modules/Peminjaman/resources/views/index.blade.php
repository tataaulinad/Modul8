
@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Data Peminjaman</h4>
            <p class="text-muted mb-0">Kelola data peminjaman buku.</p>
        </div>
        <button class="btn btn-primary" id="addBtn">
            Tambah Peminjaman
        </button>
    </div>

    <div id="alert-container"></div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-5">
                    <input type="text" id="search" class="form-control"
                        placeholder="Cari nama atau judul buku...">
                </div>
                <div class="col-md-3">
                    <span class="text-muted">
                        Total data: <strong id="total-count">0</strong>
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover"
                    id="peminjaman-table">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center">
                                Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="peminjamanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="peminjamanModalLabel">
                    Tambah Peminjaman
                </h5>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>

            <form id="peminjamanForm" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam"
                            id="nama_peminjam" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul_buku"
                            id="judul_buku" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam"
                            id="tanggal_pinjam" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali"
                            id="tanggal_kembali" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Pilih Status</option>
                            <option value="Dipinjam">Dipinjam</option>
                            <option value="Dikembalikan">Dikembalikan</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bukti Peminjaman</label>
                        <input type="file" name="berkas" id="berkas"
                            class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                        <div class="invalid-feedback"></div>
                        <div id="current-file" class="small mt-2"></div>
                        <small class="text-muted">
                            Format JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveBtn">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    window.peminjamanUrls = {
        data: @json(route('peminjaman.data')),
        store: @json(route('peminjaman.store')),
        edit: @json(route('peminjaman.edit', '__ID__')),
        update: @json(route('peminjaman.update', '__ID__')),
        destroy: @json(route('peminjaman.destroy', '__ID__'))
    };
</script>
<script src="{{ asset('js/peminjaman.js') }}"></script>
@endsection