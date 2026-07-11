<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    protected $fillable = ['title', 'description', 'location', 'type', 'experience', 'salary_min', 'salary_max', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'salary_min' => 'decimal:2', 'salary_max' => 'decimal:2'];
    public function applications(): HasMany { return $this->hasMany(CareerApplication::class); }
    public function scopeActive($query) { return $query->where('is_active', true); }
}
