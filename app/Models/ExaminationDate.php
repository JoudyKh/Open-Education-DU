<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExaminationDate extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'semester_id',
        'curriculum_id',
        'start_time',
        'end_time',
        'date',
    ];
    public static $searchable = [
        'semester_id',
        'curriculum_id',
        'start_time',
        'end_time',
        'date',
        
    ];
    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function curriculum(){
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }
}
