<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Authenticatable
{
    use HasFactory, HasApiTokens, SoftDeletes, HasRoles, LogsModelChanges;
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'birth_place',
        'birth_date',
        'national_id',
        'place_of_registration',
        'id_front_side_image',
        'id_back_side_image',
        'admin_decision_date',
        'admin_decision_number',
    ];
    public static $searchable = [
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'birth_place',
        'birth_date',
        'national_id',
        'place_of_registration',
        'admin_decision_date',
        'admin_decision_number',
    ];
}
