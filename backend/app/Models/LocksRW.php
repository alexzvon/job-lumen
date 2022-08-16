<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocksRW extends Model
{
    const SDN_UPDATE_LOCK = 1001;

    protected $table = 'locks_r_w';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid'
    ];

    public $timestamps = false;
}
