<?php

namespace App\Notifications;

use App\Models\Laudo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LaudoEnviadoNotification extends Notification
{
    use Queueable;

    protected $laudo;

    /**
     * Create a new notification instance.
     */
    public function __construct(Laudo $laudo)
    {
        $this->laudo = $laudo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Por enquanto apenas database, pode adicionar 'mail' depois
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Laudo Disponível para Assinatura')
                    ->line('Um novo laudo está disponível para assinatura.')
                    ->action('Assinar Laudo', route('assinatura.show', $this->laudo->link_assinatura_unico))
                    ->line('Obrigado por usar nosso sistema!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'laudo_id' => $this->laudo->id,
            'cliente' => $this->laudo->cliente->nome,
            'servico' => $this->laudo->servico->tipo_servico,
            'link' => route('assinatura.show', $this->laudo->link_assinatura_unico),
            'message' => 'Novo laudo disponível para assinatura: ' . $this->laudo->servico->tipo_servico,
        ];
    }
}
