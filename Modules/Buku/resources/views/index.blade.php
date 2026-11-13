
@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Daftar Buku</h4>
        <p class="text-muted mb-0">Kelola koleksi buku perpustakaan.</p>
    </div>

    @if (auth()->user()->isAdmin())
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            Tambah Buku
        </a>
    @endif
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('buku.index') }}"
            class="d-flex gap-2">
            <input type="search" name="search"
                value="{{ $search }}"
                class="form-control"
                placeholder="Cari judul, penulis, atau penerbit...">

            <button type="submit" class="btn btn-primary">
                Cari
            </button>

            @if ($search !== '')
                <a href="{{ route('buku.index') }}"
                    class="btn btn-light border">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Stok</th>

                    @if (auth()->user()->isAdmin())
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse ($bukus as $buku)
                    <tr>
                        <td>{{ $bukus->firstItem() + $loop->index }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ $buku->penerbit }}</td>
                        <td>{{ $buku->tahun_terbit }}</td>
                        <td>{{ $buku->stok }}</td>

                        @if (auth()->user()->isAdmin())
                            <td class="text-nowrap">
                                <a href="{{ route('buku.edit', $buku) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('buku.destroy', $buku) }}"
                                    method="POST"
                                    class="d-inline"
                                    data-confirm="Buku {{ $buku->judul }} akan dihapus.">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-sm btn-outline-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}"
                            class="text-center py-4">
                            Belum ada data buku.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($bukus->hasPages())
        <div class="card-footer bg-white">
            {{ $bukus->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

@endsection
