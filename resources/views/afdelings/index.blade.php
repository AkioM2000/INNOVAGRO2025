@extends('layouts.app')

@section('title', 'Afdeling')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Afdeling</h1>
    <a href="{{ route('afdelings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Afdeling
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Afdeling</h3>
                        <a href="{{ route('afdelings.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Afdeling
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Divisi</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($afdelings as $afdeling)
                                <tr>
                                    <td>{{ $afdeling->name }}</td>
                                    <td>{{ $afdeling->division->name ?? 'Tidak ada divisi' }}</td>
                                    <td>{{ $afdeling->description }}</td>
                                    <td>
                                        <div class="btn-group gap-2">
                                            <a href="{{ route('afdelings.edit', $afdeling) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('afdelings.destroy', $afdeling) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus afdeling ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada afdeling ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $afdelings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Auto hide alert after 5 seconds
    if ($('#success-alert').length > 0) {
        setTimeout(function() {
            $('#success-alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
});
</script>
@endpush
