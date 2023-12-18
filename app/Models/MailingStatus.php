<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MailingStatus extends Pivot
{
    protected $table = 'mailing_statuses';

    protected $fillable = [
        'status',
        'mailing_id',
        'phone_id'
    ];

    public function mailing()
    {
        return $this->belongsTo(Mailing::class);
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }
}
