@auth
    @if(!Auth::user()->hasRole('admin'))
        <li class="slide mb-2">
            <a class="side-menu__item d-flex align-items-center text-white text-decoration-none p-3 rounded {{ request()->routeIs('notifications.*') ? 'active bg-primary' : 'hover-bg-primary' }}"
                href="{{ route('notifications.index') }}">
                <i class="fas fa-bell me-2"></i>
                <span class="side-menu__label">Notifikasi</span>
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="badge bg-danger ms-auto">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </a>
        </li>
    @endif
@endauth

<!-- Notifications Modal -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationsModalLabel">Notifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(Auth::user()->notifications->count() > 0)
                    <div class="list-group">
                        @foreach(Auth::user()->notifications as $notification)
                            <div class="list-group-item {{ !$notification->read_at ? 'list-group-item-warning' : '' }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $notification->data['message'] }}</h6>
                                    <small>
                                        @php
                                            $parsedDate = \App\Helpers\DateHelper::parseIndonesianDate($notification->data['processed_at']);
                                            echo $parsedDate ? $parsedDate->diffForHumans() : 'Tanggal tidak valid';
                                        @endphp
                                    </small>
                                </div>
                                <p class="mb-1">Dokumen: {{ $notification->data['document_title'] }}</p>
                                <p class="mb-1">Status:
                                    <span class="badge bg-{{ $notification->data['status'] === 'approved' ? 'success' : 'danger' }}">
                                        {{ $notification->data['status'] === 'approved' ? 'Disetujui' : 'Ditolak' }}
                                    </span>
                                </p>
                                @if($notification->data['status'] === 'rejected' && !empty($notification->data['rejection_reason']))
                                    <p class="mb-1">Alasan: {{ $notification->data['rejection_reason'] }}</p>
                                @endif
                                <small>Diproses oleh: {{ $notification->data['processed_by'] }}</small>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Tandai semua sebagai telah dibaca</button>
                        </form>
                    </div>
                @else
                    <p class="text-center mb-0">Tidak ada notifikasi</p>
                @endif
            </div>
        </div>
    </div>
</div>
