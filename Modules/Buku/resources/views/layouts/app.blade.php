<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}"
        href="{{ route('buku.index') }}">
        <i class="bi bi-book me-1"></i> Buku
    </a>
</li>