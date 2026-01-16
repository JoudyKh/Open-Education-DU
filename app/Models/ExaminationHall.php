<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExaminationHall extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'semester_id',
        'name',
        'place',
        'default_capacity',
    ];
    public static $searchable = [
        'semester_id',
        'name',
        'place',
        'default_capacity',
    ];
    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
