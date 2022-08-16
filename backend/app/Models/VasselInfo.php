<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VasselInfo extends Model
{
    protected $table = 'vassel_info';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid',
        'uid_sdn_entry',
        'call_sign',
        'vessel_type',
        'vessel_flag',
        'vessel_owner',
        'gross_registered_tonnage'
    ];

    public $timestamps = false;
}
