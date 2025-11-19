<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'author_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
