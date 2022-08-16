<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkaList extends Model
{
    protected $table = 'aka_list';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid',
        'uid_sdn_entry',
        'type',
        'category',
        'last_name'
    ];

    public $timestamps = false;
}
