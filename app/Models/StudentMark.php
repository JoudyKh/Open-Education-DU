<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

    class StudentMark extends Model
    {
        use HasFactory, SoftDeletes, LogsModelChanges;
        protected $fillable = [
            'student_id',
            'semester_id',
            'curriculum_id',
            'mark',
            'written_mark',
            'is_successful',
        ];
        protected $casts = [
            'is_successful' => 'boolean',
        ];
        public static $searchable = [
            'student_id',
            'semester_id',
            'curriculum_id',
            'mark',
            'written_mark',
            'is_successful',

        ];
        protected static function boot()  
        {  
            parent::boot();  

            static::saving(function ($studentMark) {  
                $curriculum = Curriculum::find($studentMark->curriculum_id);  
                if ($curriculum) {  
                    $studentMark->is_successful = $studentMark->mark >= $curriculum->min_pass_mark;  
                }  
            });  
        }  
        public function student(){
            return $this->belongsTo(Student::class, 'student_id');
        }
        public function semester(){
            return $this->belongsTo(Semester::class, 'semester_id');
        }
        public function curriculum(){
            return $this->belongsTo(Curriculum::class, 'curriculum_id');
        }
    }
