<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSpkPpbjNotification extends Notification
{
    use Queueable;

    public $spkPpbj;
    public $uploaderName;

    /**
     * Create a new notification instance.
     */
    public function __construct($spkPpbj, $uploaderName)
    {
        $this->spkPpbj = $spkPpbj;
        $this->uploaderName = $uploaderName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Pengajuan SPK & PPBJ Baru')
                    ->line('Anda menerima pengajuan SPK & PPBJ baru.')
                    ->line('Nomor Dokumen: ' . $this->spkPpbj->nomor_dokumen)
                    ->line('Perihal: ' . $this->spkPpbj->perihal)
                    ->line('Diajukan oleh: ' . $this->uploaderName)
                    ->action('Lihat Detail', url('/spk-ppbj/' . $this->spkPpbj->id))
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pengajuan SPK & PPBJ Baru',
            'message' => 'Pengajuan SPK & PPBJ dengan nomor ' . $this->spkPpbj->nomor_dokumen . ' menunggu persetujuan Anda.',
            'url' => '/spk-ppbj/' . $this->spkPpbj->id,
            'type' => 'spk-ppbj',
            'spk_ppbj_id' => $this->spkPpbj->id,
            'uploader_name' => $this->uploaderName,
        ];
    }
}
