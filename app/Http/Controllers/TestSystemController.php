<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestSystemController extends Controller
{
    public function testResponse()
    {
        return response()->json('Server is Running');
    }

    public function startFrying()
    {

    }
}
