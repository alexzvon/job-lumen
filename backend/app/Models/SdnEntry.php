<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SdnEntry extends Model
{
    protected $table = 'sdn_entry';

    protected $primaryKey = 'uid';

    protected $fillable = [
        'uid',
        'first_name',
        'last_name',
        'sdn_type',
        'title',
        'remarks'
    ];

    public $timestamps = false;

    public function ProgramList()
    {
        return $this->hasMany(ProgramList::class, 'uid_sdn_entry', 'uid');
    }

    public function AkaList()
    {
        return $this->hasMany(AkaList::class, 'uid_sdn_entry', 'uid');
    }

    public function AddressList()
    {
        return $this->hasMany(AddressList::class, 'uid_sdn_entry', 'uid');
    }

    public function IdList()
    {
        return $this->hasMany(IdList::class, 'uid_sdn_entry', 'uid');
    }

    public function DateOfBirthList()
    {
        return $this->hasMany(DateOfBirthList::class, 'uid_sdn_entry', 'uid');
    }

    public function PlaceOfBirthList()
    {
        return $this->hasMany(PlaceOfBirthList::class, 'uid_sdn_entry', 'uid');
    }

    public function VasselInfo()
    {
        return $this->hasMany(VasselInfo::class, 'uid_sdn_entry', 'uid');
    }

    public function NationalityList()
    {
        return $this->hasMany(NationalityList::class, 'uid_sdn_entry', 'uid');
    }

    public function CitizenshipList()
    {
        return $this->hasMany(CitizenshipList::class, 'uid_sdn_entry', 'uid');
    }
}
