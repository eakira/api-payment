<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function response(?array $response, int $status_code = 200)
    {
        return response()->json($response, $status_code);
    }
}
