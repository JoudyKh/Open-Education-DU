<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramRule extends Model
{
    use HasFactory, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
    ];
    public static $searchable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
    ];
}
