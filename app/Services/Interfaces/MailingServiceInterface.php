<?php

namespace App\Services\Interfaces;

use App\Models\Mailing;

interface MailingServiceInterface
{
    public function createRecord(string $message, array $phones);
    public function handleJob(Mailing $mailing, string $token);
}