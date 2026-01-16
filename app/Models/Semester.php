<?php

namespace App\Models;

use App\Observers\SemesterObserver;
use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Semester extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'name',
        'year',
        'start_date',
        'end_date',
        'registration_start_date',
        'registration_end_date',
        'has_exception',
        'max_fail_regular',
        'max_fail_dropout',
        'count_curriculums_optional',
        'count_curriculums_mandatory',
    ];
    public static $searchable = [
        'name',
        'year',
        'start_date',
        'end_date',
        'registration_start_date',
        'registration_end_date',
        'has_exception',
        'max_fail_regular',
        'max_fail_dropout',
        'count_curriculums_optional',
        'count_curriculums_mandatory',
    ];
    protected $appends = ['is_available'];
    public static function boot()
    {
        parent::boot();
        // Register the observer
        self::observe(SemesterObserver::class);
    }
    // the curriculum original semester
    public function curriculum(){
        return $this->hasMany(Semester::class, 'semester_id');
    }
    public function curriculums()
    {
        return $this->belongsToMany(Curriculum::class, 'semester_curriculum', 'semester_id', 'curriculum_id');
    }
    public function getIsAvailableAttribute()
    {
        $optionalCurriculumsCount = $this->curriculums()->where('curriculums.is_optional', 1)->count();
        $mandatoryCurriculumsCount = $this->curriculums()->where('curriculums.is_optional', 0)->count();

        return $optionalCurriculumsCount > $this->count_curriculums_optional
            && $mandatoryCurriculumsCount > $this->count_curriculums_mandatory;
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'semester_id');
    }
    public function academicFees()
    {
        return $this->hasMany(AcademicFee::class, 'semester_id');
    }
    public function universityServicesFees()
    {
        return $this->hasMany(UniversityServicesFee::class, 'semester_id');
    }
    public function examinationHalls()
    {
        return $this->hasMany(ExaminationHall::class, 'semester_id');
    }
    public function examinationDates()
    {
        return $this->hasMany(ExaminationDate::class, 'semester_id');
    }
    public function marks(){
        return $this->hasMany(StudentMark::class, 'semester_id');
    }
}
