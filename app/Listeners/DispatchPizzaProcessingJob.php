<?php

namespace App\Listeners;

use App\Events\PizzaOrderTaken;
use App\Jobs\PizzaProcessingJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\Console\Output\ConsoleOutput;

class DispatchPizzaProcessingJob
{   
    public $pizza;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PizzaOrderTaken  $event
     * @return void
     */
    public function handle(PizzaOrderTaken $event)
    {
        $this->pizza = $event->pizza;

        // Here we will dispatch jobs from this
        $conOut = new ConsoleOutput();
        $conOut->writeln("******From Listener******");
        (new PizzaProcessingJob($event->pizza))->dispatch($event->pizza)->onQueue('long-process');
        
    }
}
