<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory; 

    protected $fillable = [
        'author_id', 'title', 'slug', 'description', 'level', 'cover_image', 'price', 'published'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

