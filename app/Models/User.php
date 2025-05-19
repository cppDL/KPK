<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')
                    ->withPivot(['status','completed_at','percentage'])
                    ->withTimestamps();
    }

    public function completedCourses()
    {
        return $this->courses()->wherePivot('status','completed');
    }

    public function testAttempts()
    {
        return $this->hasMany(TestAttempt::class)
                    ->orderByDesc('created_at');
    }
}
