<?php

namespace App\Notifications;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $document;
    protected $action;

    public function __construct(Document $document, string $action)
    {
        $this->document = $document;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Document ' . ucfirst($this->action))
            ->greeting('Hello ' . $notifiable->name . '!');

        switch ($this->action) {
            case 'created':
                $message->line('A new document has been uploaded: ' . $this->document->title)
                    ->line('Category: ' . $this->document->category->name)
                    ->line('Uploaded by: ' . $this->document->user->name);
                break;
            case 'updated':
                $message->line('Document has been updated: ' . $this->document->title)
                    ->line('Updated by: ' . $this->document->user->name);
                break;
            case 'deleted':
                $message->line('Document has been deleted: ' . $this->document->title)
                    ->line('Deleted by: ' . $this->document->user->name);
                break;
        }

        return $message->action('View Document', route('documents.show', $this->document))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'document_id' => $this->document->id,
            'title' => $this->document->title,
            'action' => $this->action,
            'user_id' => $this->document->user_id,
            'user_name' => $this->document->user->name,
        ];
    }
}
