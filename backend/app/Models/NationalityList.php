<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NationalityList extends Model
{
  protected $table = 'nationality_list';

  protected $primaryKey = 'uid';

  protected $fillable = [
    'uid',
    'uid_sdn_entry',
    'country',
    'main_entry',
  ];

  public $timestamps = false;
}
