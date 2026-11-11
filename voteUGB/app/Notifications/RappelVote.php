<?php

namespace App\Notifications;

use App\Models\Votes;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelVote extends Notification
{
    public function __construct(private Votes $scrutin)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('UGB Vote — dernier jour pour voter')
            ->greeting('Bonjour '.ucfirst($notifiable->prenom).',')
            ->line('Le scrutin de votre UFR se termine le '.$this->scrutin->date_fin->format('d/m/Y').' à minuit et vous n\'avez pas encore voté.')
            ->line('Voter prend moins d\'une minute, depuis votre téléphone ou votre ordinateur.')
            ->action('Voter maintenant', route('election'))
            ->salutation('Votre avenir, votre voix. — L\'équipe UGB Vote');
    }
}
