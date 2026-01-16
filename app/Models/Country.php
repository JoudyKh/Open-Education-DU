<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, LogsModelChanges;
    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
    ];
    public function cities(){
        return $this->belongsTo(City::class, 'country_id');
    }
}
