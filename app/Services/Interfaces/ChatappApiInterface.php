<?php

namespace App\Services\Interfaces;

interface ChatappApiInterface
{
    public function tokens($appId, $email, $password);
    public function refresh($refreshToken);
    public function setToken($token);
    public function messageWhatsApp($message, $phone);
}