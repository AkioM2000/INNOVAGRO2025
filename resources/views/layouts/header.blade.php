<!-- app-Header -->
<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
            <!-- sidebar-toggle-->
            <a class="logo-horizontal" href="{{ route('dashboard') }}">
                <div class="header-brand-img desktop-logo">
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="fas fa-archive fa-2x text-white me-2"></i>
                        <h4 class="fw-bold mt-4 text-white text-uppercase text-truncate">Office Archive</h4>
                    </div>
                </div>
                <div class="header-brand-img light-logo1">
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="fas fa-archive fa-2x text-primary me-2"></i>
                        <h4 class="fw-bold mt-4 text-dark text-uppercase text-truncate">Office Archive</h4>
                    </div>
                </div>
            </a>
            <!-- LOGO -->
            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <!-- SEARCH -->
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex justify-content-between order-lg-2">
                            <!-- Theme-Layout -->
                            <div class="dropdown d-flex">
                                <a class="nav-link icon full-screen-link nav-link-bg">
                                    <i class="fe fe-minimize fullscreen-button"></i>
                                </a>
                            </div>
                            <!-- FULL-SCREEN -->
                            @auth
                            <!-- Notifications Dropdown Menu -->
                            <div class="dropdown d-flex notifications">
                                <a class="nav-link icon" data-bs-toggle="dropdown">
                                    <i class="fe fe-bell"></i>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="pulse-danger"></span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <div class="drop-heading border-bottom">
                                        <div class="d-flex">
                                            <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">Notifications</h6>
                                        </div>
                                    </div>
                                    <div class="notifications-menu">
                                        @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                                            <a class="dropdown-item d-flex" href="{{ route('documents.show', $notification->data['document_id']) }}">
                                                <div class="me-3 notifyimg bg-primary brround box-shadow-primary">
                                                    <i class="fe fe-file-text"></i>
                                                </div>
                                                <div class="mt-1 wd-80p">
                                                    <h5 class="notification-label mb-1">{{ $notification->data['title'] }}</h5>
                                                    <span class="notification-subtext">{{ ucfirst($notification->data['action']) }} by {{ $notification->data['user_name'] }}</span>
                                                    <span class="notification-subtext">{{ $notification->created_at->diffForHumans() }}</span>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="dropdown-item text-center">No notifications</div>
                                        @endforelse
                                    </div>
                                    @if(auth()->user()->notifications->count() > 0)
                                        <div class="dropdown-divider m-0"></div>
                                        <a href="{{ route('notifications.index') }}" class="dropdown-item text-center p-3 text-muted">View all Notifications</a>
                                    @endif
                                </div>
                            </div>

                            <!-- SIDE-MENU -->
                            <div class="dropdown d-flex profile-1">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                    <div class="text-end">
                                        <h5 class="text-dark mb-0 me-4 fs-14 fw-semibold">{{ Auth::user()->name }}</h5>
                                        <small class="text-muted me-4">{{ Auth::user()->roles->first()->name ?? 'User' }}</small>
                                    </div>
                                    <i class="far fa-user-circle fa-2x text-primary"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="dropdown-icon fe fe-user"></i> Profile
                                    </a>
                                    <a class="dropdown-item" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modalLogout">
                                        <i class="dropdown-icon fe fe-log-out"></i> Log out
                                    </a>
                                </div>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /app-Header -->
