<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramList extends Model
{
    protected $table = 'program_list';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid', 'uid_sdn_entry', 'program'
    ];

    public $timestamps = false;
}
