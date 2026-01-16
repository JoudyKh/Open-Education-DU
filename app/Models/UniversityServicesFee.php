<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UniversityServicesFee extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'semester_id',
        'name',
        'fee',
        'discount_percentage',
        'discount_type_id',
    ];
    public static $searchable = [
        'semester_id',
        'name',
        'fee',
        'discount_percentage',
        'discount_type_id',
    ];
    public function discountType(){
        return $this->belongsTo(DiscountType::class, 'discount_type_id');
    }
    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
