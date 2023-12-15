<?php

namespace App\Repositories;

use App\Models\Mailing;

class MailingRepository extends AbstractRepository
{
    function __construct(protected Mailing $model)
    {
    }

    function createAndAttachPhones(string $message, array $phoneIds): Mailing
    {
        $mailing = $this->model->create(['message' => $message]);
        $mailing->phones()->attach($phoneIds);
        return $mailing;
    }
}
