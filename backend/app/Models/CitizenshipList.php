<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitizenshipList extends Model
{
  protected $table = 'citizenship_list';

  protected $primaryKey = 'uid';

  protected $fillable = [
    'uid',
    'uid_sdn_entry',
    'country',
    'main_entry',
  ];

  public $timestamps = false;
}
