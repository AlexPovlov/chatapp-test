<?php

namespace App\Repositories;

use App\Models\MailingStatus;
use Illuminate\Database\Eloquent\Collection;

class MailingStatusRepository extends AbstractRepository
{
    function __construct(protected MailingStatus $model)
    {
    }

    function getFromMailingId($mailingId): Collection
    {
        return $this->model->whereMailingId($mailingId)->get();
    }
}