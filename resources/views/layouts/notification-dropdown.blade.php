@auth
    @if(Auth::user()->hasRole('admin') || Auth::user()->is_admin)
        <!-- Notifikasi SPK & PPBJ -->
        @php
            $spkPpbjNotifications = Auth::user()->unreadNotifications()
                ->where('type', 'App\\Notifications\\NewSpkPpbjNotification')
                ->count();
        @endphp
        <li class="slide mb-2">
            <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('spk-ppbj.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                href="{{ route('spk-ppbj.index') }}">
                <i class="fas fa-file-contract me-2"></i>
                <span class="side-menu__label">Pengajuan SPK & PPBJ</span>
                @if($spkPpbjNotifications > 0)
                    <span class="badge bg-danger ms-auto">{{ $spkPpbjNotifications }}</span>
                @endif
            </a>
        </li>

        <!-- Permintaan Penghapusan -->
        @php
            $deletionNotifications = Auth::user()->unreadNotifications()
                ->where('type', '!=', 'App\\Notifications\\NewSpkPpbjNotification')
                ->count();
        @endphp
        <li class="slide mb-2">
            <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('document-deletion-requests.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                href="{{ route('document-deletion-requests.index') }}">
                <i class="fas fa-trash-alt me-2"></i>
                <span class="side-menu__label">Permintaan Penghapusan</span>
                @if($deletionNotifications > 0)
                    <span class="badge bg-danger ms-auto">{{ $deletionNotifications }}</span>
                @endif
            </a>
        </li>
    @endif
    
    <!-- File Dihapus -->
    <li class="slide mb-2">
        <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('deleted-documents.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
            href="{{ route('deleted-documents.index') }}">
            <i class="fas fa-history me-2"></i>
            <span class="side-menu__label">File Dihapus</span>
        </a>
    </li>
@endauth
