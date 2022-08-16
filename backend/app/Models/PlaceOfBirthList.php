<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceOfBirthList extends Model
{
    protected $table = 'place_of_birth_list';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid',
        'uid_sdn_entry',
        'place_of_birth',
        'main_entry'
    ];

    public $timestamps = false;
}
