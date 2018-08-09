<?php

namespace App\Notifications;

use App\Entities\Outage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubscribedOutagePlanned extends Notification
{
    use Queueable;

    /**
     * @var Outage
     */
    protected $outage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($outage)
    {
        $this->outage = $outage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('no-reply@sugarsplashes.com')
            ->subject('CEB Outage Watcher: Planned outage notification')
            ->greeting("Hello " . $notifiable->name)
            ->line('New outage planned '. $this->outage->pretty_print)
            ->line("More details:")
            ->line('"' . $this->outage->roads . '"')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
