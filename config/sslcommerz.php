<?php

return [
    'store_id' => env('agroc68f39cbdb4adf'),
    'store_password' => env('agroc68f39cbdb4adf@ssl'),
    'api_domain' => env('SSL_MODE') === 'sandbox'
        ? 'https://sandbox.sslcommerz.com'
        : 'https://securepay.sslcommerz.com',
];
