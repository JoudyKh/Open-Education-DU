<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Discount extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'semester_id',
        'name',
        'percentage',
        'is_exhausted_student',
    ];
    public static $searchable = [
        'name',
        'percentage',
        'is_exhausted_student',
    ];
    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
