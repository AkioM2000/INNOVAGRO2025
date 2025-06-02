@extends('layouts.app')

@section('title', 'Dokumen')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Dokumen</h1>
    <a href="{{ route('documents.create') }}" class="btn btn-primary">
        <i class="fas fa-upload"></i> Upload Dokumen
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
                        <h3 class="card-title">Daftar Dokumen</h3>
                        <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-upload"></i> Upload Dokumen
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('documents.index') }}" method="GET" class="mb-4">
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Cari judul, deskripsi, atau nomor file..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="afdeling_id" id="afdeling_id" class="form-control">
                                        <option value="">Semua Afdeling</option>
                                        @foreach($afdelings as $afdeling)
                                        <option value="{{ $afdeling->id }}"
                                            {{ request('afdeling_id') == $afdeling->id ? 'selected' : '' }}>
                                            {{ $afdeling->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-afdeling="{{ $category->afdeling_id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="user_id" class="form-control">
                                        <option value="">Semua Pengguna</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="date" name="date_from" class="form-control" placeholder="Dari Tanggal"
                                        value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="date" name="date_to" class="form-control" placeholder="Sampai Tanggal"
                                        value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-sync"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nomor File</th>
                                    <th>Judul</th>
                                    <th>Afdeling</th>
                                    <th>Kategori</th>
                                    <th>Diunggah Oleh</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                <tr>
                                    <td>{{ $document->file_number }}</td>
                                    <td>{{ $document->title }}</td>
                                    <td>{{ $document->afdeling->name ?? 'Tidak ada afdeling' }}</td>
                                    <td>{{ $document->category->name }}</td>
                                    <td>{{ $document->user->name }}</td>
                                    <td>{{ $document->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group gap-2">
                                            <a href="{{ route('documents.show', $document) }}"
                                                class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('documents.edit', $document) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(Auth::user()->hasRole('admin'))
                                            <form action="{{ route('documents.destroy', $document) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @else
                                            <a href="{{ route('document-deletion-requests.create', $document) }}"
                                                class="btn btn-sm btn-warning" title="Ajukan Penghapusan">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            @endif
                                            <a href="{{ route('documents.download', $document) }}"
                                                class="btn btn-sm btn-success" title="Unduh">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada dokumen ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $documents->links() }}
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
    // Auto hide alert after 5 seconds
    if ($('#success-alert').length > 0) {
        setTimeout(function() {
            $('#success-alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000); // 5 seconds
    }

    // Filter categories based on selected afdeling
    $('#afdeling_id').on('change', function() {
        var afdelingId = $(this).val();
        var categorySelect = $('#category_id');

        // Hide all options first
        categorySelect.find('option[data-afdeling]').hide();
        categorySelect.val('');

        if (afdelingId) {
            // Show only categories for selected afdeling
            categorySelect.find('option[data-afdeling="' + afdelingId + '"]').show();
        } else {
            // Show all categories if no afdeling selected
            categorySelect.find('option[data-afdeling]').show();
        }
    });

    // Trigger change on page load if afdeling is selected
    if ($('#afdeling_id').val()) {
        $('#afdeling_id').trigger('change');
    }
});
</script>
@endpush
