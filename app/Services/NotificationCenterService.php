<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NotificationCenterService
{
    /**
     * Sent Notification message throw sms 
     *
     * @param array $payload
     * @return void
     */
    public function toSms(array $payload) : void
    {
        $user = $payload["user"];
        $message = $payload["message"];
        $sentAt = now()->format("d-m-Y h:i A");
        
        $smsPayload = [
            "userName" => config("msegat.userName"),
            "numbers" => $user->phone,
            "userSender" => config("msegat.userSender"),
            "apiKey" => config("msegat.apiKey"),
            "msg" => now() . ": " . $payload["message"] 
        ];

        $response = Http::withHeaders([
            "Content-Type" => "application/json"
        ])->timeout(60)
        ->post(config("msegat.apiUrl"), $smsPayload);

        Log::info([
            "service_type" => "SMS",
            "user" => $user->toArray(),
            "message" => $message,
            "response" => $response->json(),
            "datetime" => now()
        ]);
    }

    /**
     * Sent Notification message throw sms 
     *
     * @param array $payload
     * @return void
     */
    public function toMail(array $payload) : void
    {
        $user = $payload["user"];
        $message = $payload["message"];

        $response = [];

        Log::info([
            "service_type" => "Email",
            "user" => $user->toArray(),
            "message" => $message,
            "response" => $response,
            "datetime" => now()
        ]);
    }
}