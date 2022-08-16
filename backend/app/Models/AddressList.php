<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressList extends Model
{
    protected $table = 'address_list';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid',
        'uid_sdn_entry',
        'city',
        'address1',
        'address2',
        'address3',
        'country',
        'postal_code'
    ];

    public $timestamps = false;
}
