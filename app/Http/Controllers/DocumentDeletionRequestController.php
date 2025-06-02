<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentDeletionRequest;
use App\Models\User;
use App\Notifications\DocumentDeletionRequestNotification;
use App\Notifications\DocumentDeletionResponseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\DeletedDocument;

class DocumentDeletionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Document $document)
    {
        return view('document-deletion-requests.create', compact('document'));
    }

    public function store(Request $request, Document $document)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        // Check if there's already a pending request
        $existingRequest = DocumentDeletionRequest::where('document_id', $document->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return redirect()->route('documents.index')
                ->with('error', 'Sudah ada permintaan penghapusan yang pending untuk dokumen ini.');
        }

        $deletionRequest = DocumentDeletionRequest::create([
            'document_id' => $document->id,
            'requested_by' => Auth::id(),
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        // Notify all admin users
        $adminUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($adminUsers as $admin) {
            $admin->notify(new DocumentDeletionRequestNotification($deletionRequest));
        }

        return redirect()->route('documents.index')
            ->with('success', 'Permintaan penghapusan dokumen telah berhasil dikirim ke admin.');
    }

    public function index()
    {
        $requests = DocumentDeletionRequest::with(['document', 'requester'])
            ->latest()
            ->paginate(10);

        return view('document-deletion-requests.index', compact('requests'));
    }

    public function process(Request $request, DocumentDeletionRequest $deletionRequest)
    {
        // Pastikan hanya admin yang bisa memproses
        if (!auth()->user()->hasRole('admin')) {
            return back()->with('error', 'Anda tidak memiliki izin untuk memproses permintaan ini.');
        }

        // Validasi
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|min:10|max:1000',
        ], [
            'rejection_reason.required_if' => 'Alasan penolakan wajib diisi jika status Ditolak',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter',
            'rejection_reason.max' => 'Alasan penolakan maksimal 1000 karakter',
        ]);

        // Periksa apakah dokumen masih ada
        if (!$deletionRequest->document) {
            return back()->with('error', 'Dokumen tidak ditemukan atau sudah dihapus.');
        }

        try {
            DB::beginTransaction();

            // Update status permintaan
            $deletionRequest->update([
                'status' => $request->status,
                'processed_by' => auth()->id(),
                'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
                'processed_at' => now()
            ]);

            // Jika disetujui, hapus dokumen
            if ($request->status === 'approved') {
                // Simpan informasi dokumen yang dihapus ke dalam deleted_documents
                DeletedDocument::create([
                    'document_id' => $deletionRequest->document_id,
                    'deleted_by' => auth()->id(),
                    'reason' => $deletionRequest->reason,
                    'deletion_request_id' => $deletionRequest->id
                ]);

                // Hapus dokumen (soft delete)
                $deletionRequest->document->delete();
            }

            // Kirim notifikasi ke pemohon
            $deletionRequest->load('requester');
            if ($deletionRequest->requester) {
                $deletionRequest->requester->notify(new DocumentDeletionResponseNotification($deletionRequest));
            }

            // Tandai notifikasi terkait sebagai sudah dibaca
            $adminUsers = User::whereHas('roles', function($query) {
                $query->where('name', 'admin');
            })->get();

            foreach ($adminUsers as $admin) {
                $admin->unreadNotifications()
                    ->where('type', 'App\\Notifications\\DocumentDeletionRequestNotification')
                    ->where('data->deletion_request_id', $deletionRequest->id)
                    ->update(['read_at' => now()]);
            }

            DB::commit();

            return redirect()->route('document-deletion-requests.index')
                ->with('success', 'Permintaan penghapusan dokumen berhasil ' . ($request->status === 'approved' ? 'disetujui' : 'ditolak') . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error processing deletion request: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses permintaan. Silakan coba lagi.');
        }
    }
}
