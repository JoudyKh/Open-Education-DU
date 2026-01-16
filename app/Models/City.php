<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, LogsModelChanges;
    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'country_id',
    ];
    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function studentInfos(){
        return $this->hasMany(ContactInfo::class, 'city_of_residence_id');
    }
}
