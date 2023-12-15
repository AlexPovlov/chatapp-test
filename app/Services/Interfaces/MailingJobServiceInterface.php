<?php

namespace App\Services\Interfaces;

use App\Models\MailingStatus;

interface MailingJobServiceInterface
{
    function setPhoneMailingStatus(MailingStatus $mailingStatus, $responseStatus): self;
    function eventMailing($mailingId): self;
}