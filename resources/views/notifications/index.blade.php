@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Notifikasi</h1>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Notifikasi</h3>
                        @if($notifications->count() > 0)
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-check-double"></i> Tandai Semua Telah Dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($notifications->count() > 0)
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item {{ !$notification->read_at ? 'list-group-item-warning' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="d-flex justify-content-between w-100">
                                                <h5 class="mb-1">{{ $notification->data['message'] }}</h5>
                                                @if(!$notification->read_at)
                                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="ms-2">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                            <i class="fas fa-check"></i> Tandai Dibaca
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <p class="mb-1">Dokumen: {{ $notification->data['document_title'] }}</p>
                                            <p class="mb-1">
                                                Status:
                                                <span class="badge bg-{{ $notification->data['status'] === 'approved' ? 'success' : 'danger' }}">
                                                    {{ $notification->data['status'] === 'approved' ? 'Disetujui' : 'Ditolak' }}
                                                </span>
                                            </p>
                                            @if($notification->data['status'] === 'rejected' && !empty($notification->data['rejection_reason']))
                                                <p class="mb-1">Alasan: {{ $notification->data['rejection_reason'] }}</p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> Diproses oleh: {{ $notification->data['processed_by'] }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i>
                                                    @php
                                                        $parsedDate = \App\Helpers\DateHelper::parseIndonesianDate($notification->data['processed_at']);
                                                        echo $parsedDate ? $parsedDate->diffForHumans() : 'Tanggal tidak valid';
                                                    @endphp
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Tidak ada notifikasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop
