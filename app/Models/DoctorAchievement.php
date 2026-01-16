<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorAchievement extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'title',
        'text',
        'type',
        'doctor_id',
    ];
    public static $searchable = [
        'title',
        'text',
        'type',
        'doctor_id',
        
    ];
    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
