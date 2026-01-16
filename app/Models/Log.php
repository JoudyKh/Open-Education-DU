<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [  
        'user_id',  
        'model_type',  
        'model_id',  
        'operation',  
        'request_payload',
    ];  
    protected $casts = [
        'created_at' => 'date:Y-m-d h:i a',
        'updated_at' => 'date:Y-m-d h:i a',
    ];
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
