<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdList extends Model
{
    protected $table = 'id_list';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid',
        'uid_sdn_entry',
        'id_type',
        'id_number'
    ];

    public $timestamps = false;
}
