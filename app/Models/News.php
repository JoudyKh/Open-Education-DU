<?php

namespace App\Models;

use App\Traits\LogsModelChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, LogsModelChanges;
    protected $fillable = [
        'title',
        'description',
    ];
    public $translatable = [
        'title',
        'description',
    ];
    public function images()
    {
        return $this->hasMany(NewsImage::class, 'news_id');
    }
}
