<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'lesson_id', 'completed', 'progress', 'answers', 'score', 'completed_at'
    ];

    protected $casts = ['answers' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
