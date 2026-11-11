<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Confirmation de participation. Le message ne contient ni le choix, ni le reçu :
 * une boîte mail ne doit jamais permettre de savoir pour qui l'étudiant a voté.
 */
class VoteEnregistre extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('UGB Vote — votre vote a bien été enregistré')
            ->greeting('Bonjour '.ucfirst($notifiable->prenom).',')
            ->line('Votre participation au scrutin de votre UFR a bien été enregistrée le '.now()->format('d/m/Y à H:i').'.')
            ->line('Votre bulletin est anonyme : il n\'est relié ni à votre compte ni à cette adresse.')
            ->action('Suivre le scrutin', route('resultat'))
            ->line('Si vous n\'avez pas voté vous-même, contactez immédiatement l\'administration.')
            ->salutation('L\'équipe UGB Vote');
    }
}
