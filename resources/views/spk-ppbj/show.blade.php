@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail SPK & PPBJ</h4>
                    <div>
                        <a href="{{ route('spk-ppbj.edit', $spkPpbj) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('spk-ppbj.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informasi Dokumen</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Nomor Dokumen</th>
                                    <td>{{ $spkPpbj->nomor_dokumen }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($spkPpbj->tanggal)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Perihal</th>
                                    <td>{{ $spkPpbj->perihal }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $spkPpbj->keterangan ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Status Dokumen</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Diupload Oleh</th>
                                    <td>{{ $spkPpbj->uploader->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Upload</th>
                                    <td>{{ $spkPpbj->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diajukan Kepada</th>
                                    <td>{{ $spkPpbj->approver_name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($spkPpbj->approved_at)
                                            <span class="badge bg-success">Disetujui</span>
                                            <small class="d-block">
                                                Pada: {{ $spkPpbj->approved_at->format('d/m/Y H:i') }}
                                            </small>
                                        @else
                                            <span class="badge bg-warning">Menunggu Persetujuan</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($spkPpbj->lampiran)
                        <div class="mb-4">
                            <h5>Lampiran</h5>
                            <a href="{{ asset('storage/' . $spkPpbj->lampiran) }}" 
                               target="_blank" 
                               class="btn btn-primary">
                                <i class="fas fa-download me-1"></i> Unduh Lampiran
                            </a>
                        </div>
                    @endif

                    @if(!$spkPpbj->approved_at && auth()->user()->name === $spkPpbj->approver_name)
                        <div class="mt-4 pt-3 border-top">
                            <form action="{{ route('spk-ppbj.approve', $spkPpbj) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" 
                                        onclick="return confirm('Apakah Anda yakin ingin menyetujui dokumen ini?')">
                                    <i class="fas fa-check me-1"></i> Setujui Dokumen
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-hide flash message after 5 seconds
    $(document).ready(function(){
        setTimeout(function(){
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endpush

@endsection
