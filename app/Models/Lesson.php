<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'slug',
        'content',
        'duration',
        'free_preview',
        'position',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            $lesson->slug = Str::slug($lesson->title);
        });
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

}
