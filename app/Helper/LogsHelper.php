<?php

use Illuminate\Support\Facades\Log;


if (!function_exists('send_log')) {
    /**
     * @param string|null $message
     * @param array $setup
     * @param string $action
     * @return void
     */
    function send_log(string $message = null, array $setup = [], string $action = 'info')
    {
        Log::{$action}($message, $setup);
    }
}
