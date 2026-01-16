<?php

namespace App\Models;

use App\Observers\DoctorObserver;
use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'academic_rank',
        'email',
        'phone',
        'fax',
        'mobile',
    ];
    public static $searchable = [
        'academic_rank',
        'email',
        'phone',
        'fax',
        'mobile',
        
    ];
    protected static function boot()
    {
        parent::boot();

        self::observe(DoctorObserver::class);

    }
    public function infos(){
        return $this->hasMany(DoctorAcademicInfo::class, 'doctor_id');
    }
    public function positions(){
        return $this->hasMany(DoctorAcademicPosition::class, 'doctor_id');
    }
    public function achievements(){
        return $this->hasMany(DoctorAchievement::class, 'doctor_id');
    } 
    public function image(){
        return $this->hasOne(DoctorImage::class, 'doctor_id');
    }
}
