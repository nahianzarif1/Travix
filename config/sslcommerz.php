<?php

return [
    'store_id' => env('SSLCOMMERZ_STORE_ID', 'testbox'),
    'store_password' => env('SSLCOMMERZ_STORE_PASSWORD', 'qwerty'),
    'api_url' => env('SSLCOMMERZ_API_URL', 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'),
    'success_url' => env('SSLCOMMERZ_SUCCESS_URL', '/payment/success'),
    'fail_url' => env('SSLCOMMERZ_FAIL_URL', '/payment/fail'),
    'cancel_url' => env('SSLCOMMERZ_CANCEL_URL', '/payment/cancel'),
];
