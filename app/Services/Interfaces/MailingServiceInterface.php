<?php

namespace App\Services\Interfaces;

use App\Models\Mailing;

interface MailingServiceInterface
{
    function createRecord(string $message, array $phones);
    function handleJob(Mailing $mailing, string $token);
}