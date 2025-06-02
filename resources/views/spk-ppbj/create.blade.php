@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Tambah Pengajuan SPK & PPBJ Baru</h4>
                    <a href="{{ route('spk-ppbj.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('spk-ppbj.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomor_dokumen" class="form-label">Nomor Dokumen</label>
                                    <input type="text" class="form-control @error('nomor_dokumen') is-invalid @enderror" 
                                           id="nomor_dokumen" name="nomor_dokumen" 
                                           value="{{ old('nomor_dokumen') }}" required>
                                    @error('nomor_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                           id="tanggal" name="tanggal" 
                                           value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="perihal" class="form-label">Perihal</label>
                                    <input type="text" class="form-control @error('perihal') is-invalid @enderror" 
                                           id="perihal" name="perihal" 
                                           value="{{ old('perihal') }}" required>
                                    @error('perihal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="approver_name" class="form-label">Diajukan Kepada</label>
                                    <select class="form-select @error('approver_name') is-invalid @enderror" 
                                            id="approver_name" name="approver_name" required>
                                        <option value="">-- Pilih Admin --</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->name }}" {{ old('approver_name') == $admin->name ? 'selected' : '' }}>
                                                {{ $admin->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('approver_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Pilih admin yang akan menyetujui</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                     id="keterangan" name="keterangan" 
                                     rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lampiran" class="form-label">Lampiran</label>
                            <input type="file" class="form-control @error('lampiran') is-invalid @enderror" 
                                   id="lampiran" name="lampiran">
                            @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-secondary me-md-2">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
