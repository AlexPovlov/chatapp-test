<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['phone'];

    function messages()
    {
        return $this->belongsToMany(Mailing::class, 'mailing_statuses')->using(MailingStatus::class)->withPivot(['status']);
    }
}
