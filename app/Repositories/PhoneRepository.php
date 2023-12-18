<?php

namespace App\Repositories;

use App\Models\Phone;

class PhoneRepository
{
    public function __construct(protected Phone $model)
    {
    }

    public function upsert(array $phones)
    {
        return $this->model->upsert($phones, ['phone']); 
    }

    public function getFromPhonesArray(array $phones)
    {
        return $this->model->whereIn('phone', $phones)->get();
    }
}
