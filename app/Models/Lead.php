<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'company',
        'tier_interest',
        'message',
        'source_page',
        'ip_address',
    ];
}
