<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    // 1. Fillable fields (for mass assignment)
    protected $fillable = ['title', 'slug', 'description', 'is_active'];

    // 2. Relationship to modules
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
    

    // 3. Default values (optional)
    protected $attributes = [
        'is_active' => true
    ];

    // 4. Casts (optional)
    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}