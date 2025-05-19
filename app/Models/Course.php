<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'status'];

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
    
    protected $attributes = [
        'status' => 'available',
    ];

    const STATUS_AVAILABLE = 'available';
    const STATUS_IN_PROGRESS = 'inprogress';
    const STATUS_COMPLETED = 'completed';

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->withPivot(['status','completed_at'])
                    ->withTimestamps();
    }

}