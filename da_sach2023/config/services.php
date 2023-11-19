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
    'facebook' => [
        'client_id' => '250367310905087',
        'client_secret' =>'41da52e353e3a6053db6f3c30cb5b5a7',
        'redirect' => '/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '753969336743-fja6cneiavpbikpps0o1vl4qe5oj4drk.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/callback/google',
      ],

];
