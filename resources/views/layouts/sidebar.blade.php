<!--APP-SIDEBAR-->
<div class="sticky">
    <div class="app-sidebar">
        <!-- Header -->
        <div class="side-header mb-4">
            <a class="header-brand1" href="{{ route('dashboard') }}">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/logo.png') }}" 
                         alt="eSima Logo" 
                         class="me-2 rounded-circle"
                         style="height: 45px; width: 45px; object-fit: cover; border: 2px solid #fff;">
                    <h3 class="fw-bold text-white mb-0" style="font-size: 28px;">eSima</h3>
                </div>
            </a>
        </div>
        <div class="main-sidemenu">
            <ul class="side-menu list-unstyled">
                <!-- Menu Utama -->
                <li class="sub-category mb-2">
                    <h6 class="text-uppercase text-white-50 ms-3">Menu</h6>
                </li>
                
                <!-- Beranda -->
                <li class="slide mb-2">
                    <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('dashboard') ? 'active bg-primary' : 'hover-bg-primary' }}"
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-3"></i>
                        <span class="side-menu__label">Beranda</span>
                    </a>
                </li>

                <!-- Transaksi -->
                <li class="sub-category mb-2 mt-4">
                    <h6 class="text-uppercase text-white-50 ms-3">Transaksi</h6>
                </li>
                <li class="slide mb-2">
                    <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('documents.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                       href="{{ route('documents.index') }}">
                        <i class="fas fa-file-alt me-3"></i>
                        <span class="side-menu__label">Dokumen</span>
                    </a>
                </li>
                <li class="slide mb-2">
                    <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('spk-ppbj.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                       href="{{ route('spk-ppbj.index') }}">
                        <i class="fas fa-file-contract me-3"></i>
                        <span class="side-menu__label">Pengajuan SPK & PPBJ</span>
                    </a>
                </li>

                <!-- Master Data (Hanya untuk Admin) -->
                @auth
                    @if(Auth::user()->is_admin || Auth::user()->hasRole('admin'))
                        <li class="sub-category mb-2 mt-4">
                            <h6 class="text-uppercase text-white-50 ms-3">Master Data</h6>
                        </li>
                        <li class="slide mb-2">
                            <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('afdelings.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                               href="{{ route('afdelings.index') }}">
                                <i class="fas fa-building me-3"></i>
                                <span class="side-menu__label">Afdeling</span>
                            </a>
                        </li>
                        <li class="slide mb-2">
                            <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('divisions.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                               href="{{ route('divisions.index') }}">
                                <i class="fas fa-sitemap me-3"></i>
                                <span class="side-menu__label">Divisi</span>
                            </a>
                        </li>
                        <li class="slide mb-2">
                            <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('categories.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                               href="{{ route('categories.index') }}">
                                <i class="fas fa-folder me-3"></i>
                                <span class="side-menu__label">Kategori</span>
                            </a>
                        </li>
                        <li class="slide mb-2">
                            <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('users.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                               href="{{ route('users.index') }}">
                                <i class="fas fa-users me-3"></i>
                                <span class="side-menu__label">Pengguna</span>
                            </a>
                        </li>
                    @endif
                @endauth

                <!-- Menu Lainnya -->
                <li class="sub-category mb-2 mt-4">
                    <h6 class="text-uppercase text-white-50 ms-3">Lainnya</h6>
                </li>
                @auth
                @if(Auth::user()->is_admin || Auth::user()->hasRole('admin'))
                @include('layouts.notification-dropdown')
                @else
                @include('layouts.user-notification-dropdown')
                @endif
                <li class="slide">
                    <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded hover-bg-danger"
                        data-bs-toggle="modal" href="#modalLogout">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span class="side-menu__label">Keluar</span>
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLogoutLabel">Konfirmasi Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin keluar?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.hover-bg-primary:hover {
    background-color: rgba(13, 110, 253, 0.2) !important;
}

.hover-bg-danger:hover {
    background-color: rgba(220, 53, 69, 0.2) !important;
}

.side-menu__item.active {
    font-weight: bold;
}
</style>
