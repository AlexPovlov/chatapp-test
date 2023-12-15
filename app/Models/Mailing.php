<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    protected $fillable = ['message'];

    function phones()
    {
        return $this->belongsToMany(Phone::class, 'mailing_statuses')->using(MailingStatus::class)->withPivot(['status']);
    }
}
