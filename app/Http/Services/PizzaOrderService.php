<?php

namespace App\Http\Services;

use App\Events\PizzaOrderTaken;
use App\Models\User;
use App\Models\Pizza;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Output\ConsoleOutput;

class PizzaOrderService
{

    private static $success = null;

    public function takePizzaOrder() 
    {   
        $user = User::first();

        if(is_null($user)) {

            $user = (new User())->create([
                'name' => 'Our Test User',
                'email' => 'user@test.com',
                'password' => Hash::make('password')
            ])->first();   

        }

        try {

            DB::connection('mysql')->beginTransaction();
            $pizza = (new Pizza())->create([
                'user_id' => $user->id,
                'pizza_status' => PIZZA::PIZZA_PENDING
            ]);
        
         } catch (\Exception $e) {
            
            DB::connection('mysql')->rollBack();
            self::$success = false;

        } finally {

            DB::connection('mysql')->commit();
            self::$success = true;

        }

        $this->startPizzaProcessing($pizza);

        return self::$success;
    }

    /**
     * $pizzaStatus will be passed in here
     * We pass Pizza Model's constant from the handle method of Job
     */
    public function updatePizzaStatus($pizza, $pizzaStatus)
    {   
        try {

            DB::connection('mysql')->beginTransaction();
            $pizza->update([
                'pizza_status' => $pizzaStatus
            ]);
        
        } catch (\Exception $e) {

            DB::connection('mysql')->rollBack();
            self::$success = false;

        } finally {

            DB::connection('mysql')->commit();
            self::$success = true;
        
        }

        return self::$success;

    }

    public function startPizzaProcessing($pizza)
    {
        // Change Status to PROCESSING
        $this->updatePizzaStatus($pizza, Pizza::PIZZA_PROCESSING);
        
        // Trigering PizzaOrderTaken Event
        event(New PizzaOrderTaken($pizza));
    }

    public function makePizza($pizza)
    {        
        // Make Pizza
        sleep(10);

        // Change Status to COMPLETE
        $this->updatePizzaStatus($pizza, Pizza::PIZZA_COMPLETE);

        return self::$success;
    }
}
