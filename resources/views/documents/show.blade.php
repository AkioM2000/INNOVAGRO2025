@extends('layouts.app')

@section('title', 'Detail Dokumen')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Detail Dokumen</h1>
    <a href="{{ route('documents.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Dokumen</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Judul</th>
                            <td>{{ $document->title }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $document->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Afdeling</th>
                            <td>{{ $document->afdeling ? $document->afdeling->name : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $document->category ? $document->category->name : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diunggah Oleh</th>
                            <td>{{ $document->user ? $document->user->name : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Unggah</th>
                            <td>{{ $document->created_at ? $document->created_at->format('d-m-Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>{{ $document->updated_at ? $document->updated_at->format('d-m-Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Ukuran File</th>
                            <td>
                                @if($document->file_size)
                                    @if($document->file_size < 1024)
                                        {{ $document->file_size }} bytes
                                    @elseif($document->file_size < 1024 * 1024)
                                        {{ number_format($document->file_size / 1024, 2) }} KB
                                    @else
                                        {{ number_format($document->file_size / (1024 * 1024), 2) }} MB
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tipe File</th>
                            <td>{{ strtoupper($document->file_type) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2">
                        @auth
                            @if(Auth::user()->hasRole('admin') || Auth::user()->id == $document->user_id)
                            <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning flex-fill">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('documents.destroy', $document) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('documents.download', $document) }}" class="btn btn-success flex-fill" target="_blank">
                                <i class="fas fa-download me-1"></i> Unduh
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Preview Dokumen</h3>
                </div>
                <div class="card-body p-0" style="height: 800px;">
                    @php
                        $extension = strtolower($document->file_type);
                    @endphp

                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ asset('storage/' . $document->file_path) }}" class="img-fluid" alt="Preview Dokumen">
                    @elseif($extension == 'pdf')
                        <object data="{{ asset('storage/' . $document->file_path) }}" type="application/pdf" width="100%" height="100%">
                            <p>Browser Anda tidak mendukung preview PDF. Silakan <a href="{{ route('documents.download', $document) }}">unduh file</a> untuk melihatnya.</p>
                        </object>
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <i class="fas fa-file fa-4x text-secondary mb-3"></i>
                                <h5>Preview tidak tersedia untuk tipe file ini</h5>
                                <p class="text-muted">Silakan unduh file untuk melihat isinya</p>
                                <a href="{{ route('documents.download', $document) }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-download me-1"></i> Unduh File
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(!Auth::user()->hasRole('admin'))
        <div class="card mt-4" id="deletion-request">
            <div class="card-header">
                <h5 class="mb-0">Permintaan Penghapusan Dokumen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('document-deletion-requests.store', $document) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan Penghapusan</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3" required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-trash"></i> Ajukan Penghapusan
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@stop

@push('css')
<style>
.btn {
    padding: 8px 16px;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn i {
    font-size: 16px;
}
</style>
@endpush
