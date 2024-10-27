<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * string or array $response
     */
    public function response(string|array|null $response, int $status_code = 200)
    {
        if(is_array($response)) {
            return response()->json($response, $status_code);
        }
            return response($response, $status_code);
    }
}
