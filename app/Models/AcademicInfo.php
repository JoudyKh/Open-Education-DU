<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicInfo extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'student_id',
        'type',
        'high_school_type',
        'high_school_certificate_source',
        'total_student_score',
        'total_certificate_score',
        'high_school_year',
        'differential_rate',
        'english_language_degree',
        'french_language_degree',
        'religious_education_degree',
        'high_school_certificate_language',
        'high_school_certificate_photo',
        'institute_name',
        'institute_specialization',
        'graduation_rate',
        'graduation_year',
        'institute_certificate_image',
        'institute_transcript_file',
        'document_decisive',
    ];
    public static $collectionData = [
        'type',
        'high_school_type',
        'high_school_certificate_source',
        'total_student_score',
        'total_certificate_score',
        'high_school_year',
        'differential_rate',
        'english_language_degree',
        'french_language_degree',
        'religious_education_degree',
        'high_school_certificate_language',
        'high_school_certificate_photo',
        'institute_name',
        'institute_specialization',
        'graduation_rate',
        'graduation_year',
        'institute_certificate_image',
        'institute_transcript_file',
        'document_decisive'
    ];
    protected $appends = [
        'differential_sum'
    ];
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function getDifferentialSumAttribute()
    {
        $language_degree = $this->high_school_certificate_language === 'english'
            ? (double) $this->french_language_degree
            : (double) $this->english_language_degree;

        return (double) $this->total_student_score - ( (double) $this->religious_education_degree + $language_degree);
    }
}
