<?php

namespace App\Notifications;

use App\Models\DocumentDeletionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentDeletionResponseNotification extends Notification
{
    use Queueable;

    protected $deletionRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(DocumentDeletionRequest $deletionRequest)
    {
        $this->deletionRequest = $deletionRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $status = $this->deletionRequest->status;
        $message = $status === 'approved'
            ? 'Permintaan penghapusan dokumen Anda telah disetujui dan dokumen telah dihapus.'
            : sprintf(
                'Permintaan penghapusan dokumen Anda telah ditolak.%s',
                $this->deletionRequest->rejection_reason ? "\nAlasan: " . $this->deletionRequest->rejection_reason : ''
            );

        return [
            'deletion_request_id' => $this->deletionRequest->id,
            'document_title' => optional($this->deletionRequest->document)->title ?? 'Dokumen telah dihapus',
            'status' => $status,
            'message' => $message,
            'rejection_reason' => $this->deletionRequest->rejection_reason,
            'processed_at' => $this->deletionRequest->processed_at->format('d-m-Y H:i'),
            'processed_by' => optional($this->deletionRequest->processor)->name ?? 'Admin',
        ];
    }
}
