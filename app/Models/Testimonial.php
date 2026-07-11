<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name', 'company', 'designation', 'content',
        'rating', 'photo_path', 'is_active', 'sort_order',
    ];
    protected $casts = ['is_active' => 'boolean', 'rating' => 'integer'];
    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('sort_order'); }
}
