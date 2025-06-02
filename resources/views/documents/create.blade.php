@extends('layouts.app')

@section('title', 'Tambah Dokumen')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Tambah Dokumen</h1>
        <a href="{{ route('documents.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="afdeling_id">Afdeling</label>
                    <select class="form-control @error('afdeling_id') is-invalid @enderror" id="afdeling_id" name="afdeling_id" required>
                        <option value="">Pilih Afdeling</option>
                        @foreach($afdelings as $afdeling)
                            <option value="{{ $afdeling->id }}" {{ old('afdeling_id') == $afdeling->id ? 'selected' : '' }}>
                                {{ $afdeling->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('afdeling_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-afdeling="{{ $category->afdeling_id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title">Judul Dokumen</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file">File Dokumen</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" name="file" required>
                        <label class="custom-file-label" for="file">Pilih file</label>
                    </div>
                    <small class="form-text text-muted">Format yang diperbolehkan: PDF, DOC, DOCX, XLS, XLSX. Maksimal ukuran: 10MB</small>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Dokumen
                </button>
            </form>
        </div>
    </div>
@stop

@push('scripts')
<script>
    $(document).ready(function() {
        // Update file input label with selected filename
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

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
            }
        });

        // Trigger change on page load if afdeling is selected
        if ($('#afdeling_id').val()) {
            $('#afdeling_id').trigger('change');
        }
    });
</script>
@endpush
