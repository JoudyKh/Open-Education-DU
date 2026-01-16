<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AcademicFee extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'curriculum_id',
        'semester_id',
        'student_year',
        'fee',
        'student_registrations_count',
    ];
    public static $searchable = [
        'curriculum_id',
        'semester_id',
        'student_year',
        'fee',
        'student_registrations_count',
    ];
    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function curriculum(){
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }
}
