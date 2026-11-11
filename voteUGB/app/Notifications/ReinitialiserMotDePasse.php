<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReinitialiserMotDePasse extends Notification
{
    public function __construct(private string $token)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $lien = route('password.reset', ['token' => $this->token, 'email' => $notifiable->email]);

        return (new MailMessage)
            ->subject('UGB Vote — réinitialisation de votre mot de passe')
            ->greeting('Bonjour '.ucfirst($notifiable->prenom).',')
            ->line('Vous avez demandé à réinitialiser le mot de passe de votre compte UGB Vote.')
            ->action('Choisir un nouveau mot de passe', $lien)
            ->line('Ce lien est valable 60 minutes et ne peut servir qu\'une fois.')
            ->line('Si vous n\'êtes pas à l\'origine de cette demande, ignorez simplement ce message.')
            ->salutation('L\'équipe UGB Vote');
    }
}
