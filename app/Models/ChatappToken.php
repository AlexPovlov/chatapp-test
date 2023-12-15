<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatappToken extends Model
{
    protected $fillable = [
        'app_id',
        'access_token',
        'refresh_token',
        'access_token_end_time',
        'refresh_token_end_time'
    ];
}
