@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Permintaan Penghapusan Dokumen</h2>
                </div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Dokumen</th>
                                    <th>Diminta Oleh</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                    <th>Tanggal Permintaan</th>
                                    <th>Diproses Oleh</th>
                                    <th>Tanggal Diproses</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $request)
                                <tr>
                                    <td>
                                        @if($request->document)
                                        {{ $request->document->title }}
                                        @else
                                        <span class="text-muted">Dokumen telah dihapus</span>
                                        @endif
                                    </td>
                                    <td>{{ $request->requester->name }}</td>
                                    <td>{{ $request->reason }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
                                            {{ $request->status === 'pending' ? 'Menunggu' : ($request->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        @if($request->processor)
                                        {{ $request->processor->name }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->processed_at)
                                        {{ $request->processed_at->format('d-m-Y H:i') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->status === 'pending' && Auth::user()->hasRole('admin'))
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#processModal{{ $request->id }}">
                                            Proses
                                        </button>

                                        <!-- Process Modal -->
                                        <div class="modal fade" id="processModal{{ $request->id }}" tabindex="-1" aria-labelledby="processModalLabel{{ $request->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="processModalLabel{{ $request->id }}">Proses Permintaan Penghapusan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('document-deletion-requests.process', $request->id) }}" method="POST" onsubmit="return validateForm(this, {{ $request->id }})">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status{{ $request->id }}" class="form-label">Status</label>
                                                                <select id="status{{ $request->id }}" name="status" class="form-select" onchange="toggleRejectionReason({{ $request->id }})">
                                                                    <option value="">Pilih Status</option>
                                                                    <option value="approved">Setujui</option>
                                                                    <option value="rejected">Tolak</option>
                                                                </select>
                                                            </div>
                                                            <div id="rejectionReason{{ $request->id }}" class="mb-3" style="display: none;">
                                                                <label for="rejection{{ $request->id }}" class="form-label">Alasan Penolakan</label>
                                                                <textarea id="rejection{{ $request->id }}" name="rejection_reason" class="form-control" rows="3" minlength="10"></textarea>
                                                                <div class="form-text">*Wajib diisi minimal 10 karakter jika status Ditolak</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-muted">
                                            @if($request->status === 'approved')
                                            <i class="fas fa-check-circle text-success"></i> Disetujui
                                            @else
                                            <i class="fas fa-times-circle text-danger"></i> Ditolak
                                            @endif
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada permintaan penghapusan dokumen</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.modal-open {
    overflow: hidden;
}

.modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto;
}

.modal-dialog {
    margin: 1.75rem auto;
    max-width: 500px;
}

.modal-content {
    position: relative;
    background-color: #fff;
    border-radius: 0.3rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle modal events
    document.querySelectorAll('.modal').forEach(function(modalEl) {
        const modal = new bootstrap.Modal(modalEl);

        // Reset form when modal is hidden
        modalEl.addEventListener('hidden.bs.modal', function() {
            const form = modalEl.querySelector('form');
            const select = form.querySelector('select[name="status"]');
            const id = modalEl.id.replace('processModal', '');
            const rejectionDiv = document.getElementById('rejectionReason' + id);

            if (form) form.reset();
            if (select) select.value = '';
            if (rejectionDiv) rejectionDiv.style.display = 'none';
        });
    });
});

function toggleRejectionReason(id) {
    const select = document.querySelector(`#processModal${id} select[name="status"]`);
    const rejectionDiv = document.getElementById('rejectionReason' + id);

    if (select && rejectionDiv) {
        const textarea = rejectionDiv.querySelector('textarea');

        if (select.value === 'rejected') {
            rejectionDiv.style.display = 'block';
            if (textarea) textarea.setAttribute('required', 'required');
        } else {
            rejectionDiv.style.display = 'none';
            if (textarea) {
                textarea.removeAttribute('required');
                textarea.value = '';
            }
        }
    }
}

function validateForm(form, id) {
    const status = form.querySelector('select[name="status"]')?.value;
    const rejectionReason = form.querySelector('textarea[name="rejection_reason"]')?.value;

    if (!status) {
        alert('Silakan pilih status terlebih dahulu');
        return false;
    }

    if (status === 'rejected') {
        if (!rejectionReason || rejectionReason.length < 10) {
            alert('Alasan penolakan wajib diisi minimal 10 karakter');
            return false;
        }
    }

    return true;
}
</script>
@endpush
