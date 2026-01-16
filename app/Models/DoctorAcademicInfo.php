<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorAcademicInfo extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'title',
        'thesis_title',
        'university_name',
        'collage_name',
        'specialization',
        'graduation_year',
        'rate',
        'degree',
        'doctor_id',
    ];
    public static $searchable = [
        'title',
        'thesis_title',
        'university_name',
        'collage_name',
        'specialization',
        'graduation_year',
        'rate',
        'degree',
        'doctor_id',
        
    ];
    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
