<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class Contact extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param $contact
     */
    public function __construct(protected array $contact)
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
