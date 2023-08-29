<?php

/**
 * This config file contains all shipping integrations credentials.
 */

return [
    "torod" => [
        "production_url" => env("TOROD_PRODUCTION_URL"),
        "stage_url" => env("TOROD_STAGE_URL"),
        "client_id" => env("TOROD_CLIENT_ID"),
        "client_secret" => env("TOROD_CLIENT_SECRET"),
    ],

    "bezz" => [
        "acccount_number" => env("BEZZ_ACCOUNT_NUMBER" ),
        "api_key" => env("BEZZ_API_KEY"),
        "base_url" => env("BEZZ_BASE_URL"),
        "bezz_webhook_secret_key" => env("BEZZ_WEBHOOK_SECRET_KEY"),
        "tracking_url" => env("BEZZ_TRACKING_URL"),
        "default_customer_email" => "@saudidates.sa"
    ]
];