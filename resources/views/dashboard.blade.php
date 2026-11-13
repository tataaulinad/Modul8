
@extends('layouts.app')

@section('title', 'Dashboard SiPustaka')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Dashboard</h3>
    <p class="text-muted">Selamat datang di Sistem Informasi Perpustakaan SiPustaka.</p>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-person-circle fs-1 text-primary"></i>
                    <div>
                        <h5 class="mb-1">Selamat Datang, {{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-0">
                            Anda login sebagai
                            <strong>{{ auth()->user()->role->value }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
