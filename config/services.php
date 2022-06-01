<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'sms' => [
        'key' => env('SMS_KEY'),
        'base_url' => env('SMS_URL', 'https://smspoh.com/api'),
        'verify_url' => env('SMS_VERIFY_LINK', 'https://verify.smspoh.com/api'),
        'send_api' => env('SMS_SEND_ENDPOINT', '/v2/send'),
        'verify_request' => env('SMS_REQUEST_ENDPOINT', '/v1/request'),
        'verify' => env('SMS_VERIFY_ENDPOINT', '/v1/verify'),
    ],

    'firebase' => [
        'url' => env('FIREBASE_URL'),
    ],

];
