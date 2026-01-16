<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactInfo extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'student_id',
        'phone_number',
        'landline_number',
        'city_of_residence_id',
        'email',
        'permanent_address',
        'current_address',
    ];
    public static $collectionData = [
        'phone_number',
        'landline_number',
        'city_of_residence_id',
        'email',
        'permanent_address',
        'current_address'
    ];
   
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_of_residence_id');
    }
}
