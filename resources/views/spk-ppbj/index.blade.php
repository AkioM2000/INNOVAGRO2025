@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Pengajuan SPK & PPBJ</h4>
                    <a href="{{ route('spk-ppbj.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Baru
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Form Pencarian -->
                    <div class="mb-4">
                        <form action="{{ route('spk-ppbj.index') }}" method="GET" class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nomor dokumen, perihal, atau penanggung jawab..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    @if(request()->has('search') && !empty(request('search')))
                                        <a href="{{ route('spk-ppbj.index') }}" class="btn btn-outline-danger">
                                            <i class="fas fa-times"></i> Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    @if(request()->has('search') && !empty(request('search')))
                        <div class="alert alert-info mb-3">
                            Hasil pencarian untuk: <strong>{{ request('search') }}</strong>
                            <span class="float-end">
                                <a href="{{ route('spk-ppbj.index') }}" class="text-dark">
                                    <i class="fas fa-times"></i> Hapus pencarian
                                </a>
                            </span>
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Dokumen</th>
                                    <th>Perihal</th>
                                    <th>Tanggal</th>
                                    <th>Diupload Oleh</th>
                                    <th>Diajukan Kepada</th>
                                    <th>Status</th>
                                    <th>Lampiran</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($spkPpbj as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nomor_dokumen }}</td>
                                    <td>{{ $item->perihal }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td>
                                        {{ $item->uploader->name ?? 'N/A' }}
                                        <br>
                                        <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>{{ $item->approver_name }}</td>
                                    <td>
                                        @if($item->approved_at)
                                            <span class="badge bg-success">Disetujui</span>
                                            <small class="d-block">{{ $item->approved_at->format('d/m/Y H:i') }}</small>
                                        @else
                                            <span class="badge bg-warning">Menunggu Persetujuan</span>
                                            <small class="d-block">Diajukan ke: {{ $item->approver_name }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->lampiran)
                                            <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-download me-1"></i> Unduh
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <!-- Tombol Lihat Detail -->
                                            <a href="{{ route('spk-ppbj.show', $item->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <!-- Tombol Approve (hanya untuk admin yang dituju) -->
                                            @if(auth()->user()->name === $item->approver_name && !$item->approved_at)
                                                <form action="{{ route('spk-ppbj.approve', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" 
                                                            title="Setujui"
                                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui dokumen ini?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <!-- Tombol Edit dan Hapus (hanya untuk admin) -->
                                            @if(auth()->user()->is_admin || auth()->user()->hasRole('admin'))
                                                <a href="{{ route('spk-ppbj.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('spk-ppbj.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="mb-0">Belum ada data pengajuan SPK & PPBJ</p>
                                            <small class="text-muted">Klik tombol "Tambah Baru" untuk menambahkan data</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($spkPpbj->hasPages())
                        <div class="mt-3">
                            {{ $spkPpbj->links() }}
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
