<?php


return [

    'success' => [
        'message' => ["message" => 'The request was successful'],
        'status_code' => 200
    ],
    'insert_sucess' => [
        'message' => ["message" => 'Created'],
        'status_code' => 201
    ],

    'not_found' => [
        'message' => null,
        'status_code' => 404
    ],
    'validation_fail' => 'Verify the submitted fields',
    'insufficient_balance' => '0',

    'error' => [
        'message' => ["message" => 'the server encountered an unexpected condition that prevented it from fulfilling the request'],
        'status_code' => 500
    ],
];
