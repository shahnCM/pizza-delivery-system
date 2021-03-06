<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PizzaOrderService;

class OrderProcessController extends Controller
{
    public function initiateProcessing(PizzaOrderService $pizzaOrderService) 
    {
        for($i = 0; $i < 500; $i++) 
        {
            $pizzaOrderService->takePizzaOrder() 
            ? $responseData = [
                'msg' => 'We have recieved your order. You will recieve notification via email.',
                'status' => 200
            ]
            : $responseData = [
                'msg' => 'Something wen wrong, Internal Server Error.',
                'status' => 500
            ];
        }

        return 
            response()
            ->json(
                $responseData['msg'], 
                $responseData['status'])
            ->header(
                'Content-Type',
                'Application/Json'
            );
    }
}
