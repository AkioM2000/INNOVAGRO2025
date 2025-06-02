@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Permintaan Penghapusan Dokumen</h2>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Informasi Dokumen</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 150px;">Judul</th>
                                <td>{{ $document->title }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $document->description ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nomor File</th>
                                <td>{{ $document->file_number }}</td>
                            </tr>
                        </table>
                    </div>

                    <form action="{{ route('document-deletion-requests.store', $document) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reason" class="form-label">Alasan Penghapusan</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror"
                                id="reason"
                                name="reason"
                                rows="4"
                                required
                                placeholder="Jelaskan alasan mengapa dokumen ini perlu dihapus...">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('documents.show', $document) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-trash-alt"></i> Ajukan Penghapusan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
