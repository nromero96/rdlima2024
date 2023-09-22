<?php

return [
    'development' => env('VISA_DEVELOPMENT', false), // Asegúrate de usar false como valor predeterminado si no está definido en el archivo .env

    'VISA_MERCHANT_ID' => env('VISA_DEVELOPMENT')
        ? env('VISA_DEV_MERCHANT_ID', '')
        : env('VISA_PRD_MERCHANT_ID', ''),

    'VISA_USER' => env('VISA_DEVELOPMENT')
        ? env('VISA_DEV_USER', '')
        : env('VISA_PRD_USER', ''),

    'VISA_PWD' => env('VISA_DEVELOPMENT')
        ? env('VISA_DEV_PWD', '')
        : env('VISA_PRD_PWD', ''),

    'VISA_URL_SECURITY' => env('VISA_DEVELOPMENT')
        ? env('VISA_DEV_URL_SECURITY', '')
        : env('VISA_PRD_URL_SECURITY', ''),

    'VISA_URL_SESSION' => env('VISA_DEVELOPMENT')
        ? env('VISA_DEV_URL_SESSION', '')
        : env('VISA_PRD_URL_SESSION', ''),

    'VISA_URL_JS' => env('VISA_DEVELOPMENT')
        ? env('VISA_DEV_URL_JS', '')
        : env('VISA_PRD_URL_JS', ''),

    'VISA_URL_AUTHORIZATION' => env('VISA_DEVELOPMENT')
        ? env('VISA_DEV_URL_AUTHORIZATION', '')
        : env('VISA_PRD_URL_AUTHORIZATION', ''),
];
