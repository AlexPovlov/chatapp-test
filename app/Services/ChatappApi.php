<?php

namespace App\Services;

use App\Services\Interfaces\ChatappApiInterface;
use GuzzleHttp\Client;

class ChatappApi implements ChatappApiInterface
{
    protected $token;

    public function __construct(protected Client $handler)
    {
    }

    public function setToken($token)
    {
        $this->token = $token;
        
        return $this;
    }

    protected function request($uri, $method = 'POST', $options = [])
    {
        $default_options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ];
        $options = array_merge($default_options, $options);
        $response = $this->handler->request($method, $uri, $options);

        return json_decode($response->getBody(), 1);
    }

    public function licenses()
    {
        $options = [
            'headers' => ['Authorization' => $this->token]
        ];

        return $this->request('licenses', 'GET', $options);
    }

    public function tokens($appId, $email, $password)
    {
        $options = [
            'json' => [
                'appId' => $appId,
                'email' => $email,
                'password' => $password,
            ]
        ];

        return $this->request('tokens', 'POST', options: $options);
    }

    public function refresh($refreshToken)
    {
        $options = [
            'headers' => ['Refresh' => $refreshToken]
        ];

        return $this->request('tokens/refresh', options: $options);
    }

    public function messageWhatsApp($message, $phone)
    {
        $response = $this->licenses();

        $licenseId = isset($response['data'][0]['licenseId'])
            ? $response['data'][0]['licenseId']
            : null;
            
        $options = [
            'headers' => ['Authorization' => $this->token],
            'json' => ['text' => $message]
        ];

        return $this->request(
            "licenses/{$licenseId}/messengers/grWhatsApp/chats/{$phone}/messages/text",
            'POST',
            $options
        );
    }
}
