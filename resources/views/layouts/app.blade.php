
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SiPustaka')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fb;
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: .3px;
        }

        .main-content {
            padding-top: 30px;
            padding-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
        }

        .table th {
            white-space: nowrap;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-book-half me-2"></i>SiPustaka
            </a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">

                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-house me-1"></i>Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('buku.index') }}">
                            <i class="bi bi-book me-1"></i>Data Buku
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peminjaman.index') }}">
                            <i class="bi bi-journal-check me-1"></i>Peminjaman
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people me-1"></i>Kelola User
                            </a>
                        </li>
                    @endif

                </ul>

                <div class="d-flex align-items-center gap-3 text-white">

                    <span class="small">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Logout
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container main-content">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @yield('scripts')

</body>
</html>
