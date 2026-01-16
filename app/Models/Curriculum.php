<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculum extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $table = 'curriculums';
    protected $fillable = [
        'code',
        'name_en',
        'name_ar',
        'min_pass_mark',
        'theoretical_mark',
        'practical_mark',
        'assistances_marks',
        'type',
        'is_optional',
        'description_file',
        'in_program',
        'year',
        'semester_id',
    ];
    public static $searchable = [
        'code',
        'name_en',
        'name_ar',
        'min_pass_mark',
        'theoretical_mark',
        'practical_mark',
        'assistances_marks',
        'type',
        'is_optional',
        'in_program',
        'year',
        'semester_id',
    ];
    // the original semester
    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function semesters(){
        return $this->belongsToMany(Semester::class, 'semester_curriculum', 'curriculum_id', 'semester_id');
    }
    public function academicFees(){
        return $this->hasMany(AcademicFee::class, 'curriculum_id');
    }
    public function examinationDates(){
        return $this->hasMany(ExaminationDate::class, 'semester_id');
    }
    public function marks(){
        return $this->hasMany(StudentMark::class, 'curriculum_id');
    }
}
