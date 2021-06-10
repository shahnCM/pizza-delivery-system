<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Pizza;
use App\Http\Services\PizzaOrderService;
use Symfony\Component\Console\Output\ConsoleOutput;

class PizzaProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pizza;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pizza)
    {
        $this->pizza = $pizza;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PizzaOrderService $pizzaOrderService)
    {
        $conOut = new ConsoleOutput();
        $conOut->writeln("******" . $this->pizza->id . "From Job******");
        $pizzaOrderService->makePizza($this->pizza);
    }
}
