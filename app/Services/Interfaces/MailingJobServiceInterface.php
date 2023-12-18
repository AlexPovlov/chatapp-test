<?php

namespace App\Services\Interfaces;

use App\Models\MailingStatus;

interface MailingJobServiceInterface
{
    public function setPhoneMailingStatus(
        MailingStatus $mailingStatus,
        $responseStatus
    ): self;

    public function eventMailing($mailingId): self;
}