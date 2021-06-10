<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Symfony\Component\Console\Output\ConsoleOutput;

class PizzaStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $pizza;
    public $pizzaStatus;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pizza, $pizzaStatus)
    {
        $this->pizza = $pizza;
        $this->pizzaStatus = $pizzaStatus;
    }

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
        $conOut = new ConsoleOutput();
        $conOut->writeln("******" . $this->pizza->id . "From Notification******");
        
        return (new MailMessage)
                    ->subject(
                        'Pizza ID: ' 
                        . $this->pizza->id. 
                        ', Your Pizza Status Notification '. 
                        $this->pizzaStatus)
                    ->line('Status of your Pizza, ' . $this->pizzaStatus)
                    ->action('Notification Action', url('/'))
                    ->line(
                        'This is a very simple implementation of pizza delivery system design, '.
                        'Thank you for testing this app.!'
                    );
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
