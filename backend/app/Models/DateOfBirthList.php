<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateOfBirthList extends Model
{
    protected $table = 'date_of_birth_list';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid',
        'uid_sdn_entry',
        'date_of_birth',
        'main_entry'
    ];

    public $timestamps = false;
}
