<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DiscountType extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'name',
    ];
    public static $searchable = ['name'];
    public function universityServicesFees(){
        return $this->hasMany(UniversityServicesFee::class, 'discount_type_id');
    }

}
