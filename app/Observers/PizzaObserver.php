<?php

namespace App\Observers;

use App\Models\Pizza;
use App\Notifications\PizzaStatusNotification;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Console\Output\ConsoleOutput;

class PizzaObserver
{
    /**
     * Handle the Pizza "created" event.
     *
     * @param  \App\Models\Pizza  $pizza
     * @return void
     */
    public function created(Pizza $pizza)
    {
        // Notify User Here For Order Taken
        // Notification::send($pizza->user, new PizzaStatusNotification($pizza));
        $pizza->user->notify((new PizzaStatusNotification($pizza, $pizza->pizza_status))->onQueue('notification'));
    }

    /**
     * Handle the Pizza "updated" event.
     *
     * @param  \App\Models\Pizza  $pizza
     * @return void
     */
    public function updated(Pizza $pizza)
    {
        // Notify User Here For Status Update
        // Notification::send($pizza->user, new PizzaStatusNotification($pizza));
        $pizza->user->notify((new PizzaStatusNotification($pizza, $pizza->pizza_status))->onQueue('notification'));
    }

}
