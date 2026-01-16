<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory, LogsModelChanges;
    protected $fillable = [
        'ar_name',
        'en_name',
    ];
    public function students(){
        return $this->hasMany(Student::class, 'province_id');
    }
}
