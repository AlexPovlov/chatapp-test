<?php

namespace App\Services\Interfaces;

interface ChatappApiInteface
{
    function tokens($appId, $email, $password);
    function refresh($refreshToken);
    function setToken($token);
    function messageWhatsApp($message, $phone);
}