<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class Contact extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected array $contact)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from('noreply@geoffreyturpin.fr', 'Geoffrey Turpin (le site)')
            ->subject('Nouveau contact depuis le site !')
            ->greeting('Bonjour !')
            ->line('Un visiteur du site vous a envoyé un message, en voici les détails :')
            ->line(new HtmlString('<b>Nom, prénom :</b>'))
            ->line($this->contact['name'])
            ->line(new HtmlString('<b>Adresse email</b>'))
            ->line(new HtmlString('<a href="mailto:' . $this->contact['email'] . '">' . $this->contact['email'] . '</a>'))
            ->line(new HtmlString('<b>Objet :</b>'))
            ->line('"' . $this->contact['subject'] . '"')
            ->line(new HtmlString('<b>Message :</b>'))
            ->line(new HtmlString(nl2br($this->contact['message'])))
            ->salutation(new HtmlString('<p>Cordialement, <br /> L\'administrateur'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
