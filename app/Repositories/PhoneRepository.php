<?php

namespace App\Repositories;

use App\Models\Phone;

class PhoneRepository
{
    function __construct(protected Phone $model)
    {
    }

    function upsert(array $phones)
    {
        
        return $this->model->upsert($phones, ['phone']); 
    }

    function getFromPhonesArray(array $phones)
    {
        return $this->model->whereIn('phone', $phones)->get();
    }
}
