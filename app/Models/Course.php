<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    // 1. Fillable fields (for mass assignment)
    protected $fillable = ['title', 'slug', 'description', 'status'];

    // 2. Relationship to modules
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
    

    // 3. Default values (optional)
    protected $attributes = [
        'status' => 'available',
    ];

    const STATUS_AVAILABLE = 'available';
    const STATUS_IN_PROGRESS = 'inprogress';
    const STATUS_COMPLETED = 'completed';
    
    // 4. Casts (optional)
    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}