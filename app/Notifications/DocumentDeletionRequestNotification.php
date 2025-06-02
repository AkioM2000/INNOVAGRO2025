<?php

namespace App\Notifications;

use App\Models\DocumentDeletionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentDeletionRequestNotification extends Notification
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Ada permintaan penghapusan dokumen baru.')
            ->line('Dokumen: ' . $this->deletionRequest->document->title)
            ->line('Diminta oleh: ' . $this->deletionRequest->requester->name)
            ->action('Lihat Permintaan', route('document-deletion-requests.index'))
            ->line('Silakan proses permintaan ini segera.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'deletion_request_id' => $this->deletionRequest->id,
            'document_id' => $this->deletionRequest->document_id,
            'document_title' => $this->deletionRequest->document->title,
            'requester_id' => $this->deletionRequest->requested_by,
            'requester_name' => $this->deletionRequest->requester->name,
            'reason' => $this->deletionRequest->reason,
            'created_at' => $this->deletionRequest->created_at,
        ];
    }
}
