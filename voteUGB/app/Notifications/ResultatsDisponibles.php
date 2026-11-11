<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResultatsDisponibles extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('UGB Vote — les résultats sont disponibles')
            ->greeting('Bonjour '.ucfirst($notifiable->prenom).',')
            ->line('Le scrutin de votre UFR est clos. Les résultats définitifs sont en ligne.')
            ->action('Voir les résultats', route('resultat'))
            ->salutation('L\'équipe UGB Vote');
    }
}
