<?php

namespace App\Services;

use App\Events\MailingStatusEvent;
use App\Models\MailingStatus;
use App\Repositories\MailingStatusRepository;
use App\Services\Interfaces\MailingJobServiceInterface;

class MailingJobService implements MailingJobServiceInterface
{
    function __construct(
        protected MailingStatusRepository $mailingStatusRepository
    ) {
    }

    function setPhoneMailingStatus(
        MailingStatus $mailingStatus,
        $responseStatus
    ): self {
        if ($responseStatus) {
            $mailingStatus->update(['status' => 'success']);
        } else {
            $mailingStatus->update(['status' => 'error']);
        }

        return $this;
    }

    function eventMailing($mailingId): self
    {
        $mailingStatuses = $this->mailingStatusRepository
            ->getFromMailingId($mailingId);
        MailingStatusEvent::broadcast($mailingId, $mailingStatuses);

        return $this;
    }
}
