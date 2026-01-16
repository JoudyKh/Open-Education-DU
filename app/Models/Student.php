<?php

namespace App\Models;

use App\Observers\StudentObserver;
use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Student extends Authenticatable
{
    use HasFactory, HasRoles, HasApiTokens, SoftDeletes, Notifiable, LogsModelChanges;
    protected $fillable = [
        'first_name_ar',
        'first_name_en',
        'last_name_ar',
        'last_name_en',
        'father_name_ar',
        'father_name_en',
        'mother_name_ar',
        'mother_name_en',
        'national_id',
        'birth_place_ar',
        'birth_place_en',
        'birth_date',
        'nationality_id',
        'id_number',
        'gender',
        'place_of_registration',
        'registration_number',
        'passport_number',
        'recruitment_division',
        'province_id',
        'university_id',
        'personal_picture',
        'id_front_side_image',
        'id_back_side_image',
        'password',
        'is_default',
        'is_active',
        'is_checked',
        'student_type',
    ];
    public static $searchable = [
        'first_name_ar',
        'first_name_en',
        'last_name_ar',
        'last_name_en',
        'father_name_ar',
        'father_name_en',
        'mother_name_ar',
        'mother_name_en',
        'national_id',
        'birth_place_ar',
        'birth_place_en',
        'birth_date',
        'nationality_id',
        'id_number',
        'gender',
        'place_of_registration',
        'registration_number',
        'passport_number',
        'recruitment_division',
        'province_id',
        'university_id',
        'personal_picture',
        'is_active',
        'is_checked',
        'student_type',
    ];
    protected $hidden = [  
        'password',  
    ];  
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->university_id = Student::generateUniversityId();
        });

        self::observe(StudentObserver::class);

    }

    public static function generateUniversityId()
    {
        $lastId = Student::withTrashed()->max('university_id');

        if ($lastId) {
            $lastNumericPart = intval(substr($lastId, 1));
            $newNumericPart = str_pad($lastNumericPart + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumericPart = '00001';
        }

        return '3' . $newNumericPart;
    }
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }
    public function contactInfo()
    {
        return $this->hasOne(ContactInfo::class, 'student_id');
    }
    public function academicInfo()
    {
        return $this->hasOne(AcademicInfo::class, 'student_id');
    }
    public function updateContactInfo(array $contactData)
    {
        $contactInfo = $this->contactInfo; // Fetches the ContactInfo model instance
        if ($contactInfo) {
            $contactInfo->update($contactData); // This will trigger the updated event
        }
    }

    public function updateAcademicInfo(array $academicData)
    {
        $academicInfo = $this->academicInfo; // Fetches the AcademicInfo model instance
        if ($academicInfo) {
            $academicInfo->update($academicData); // This will trigger the updated event
        }
    }
    public function marks(){
        return $this->hasMany(StudentMark::class, 'student_id');
    }
}
