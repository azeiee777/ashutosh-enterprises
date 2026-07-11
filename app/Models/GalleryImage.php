<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['title', 'category', 'image_path', 'description', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];
    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('sort_order'); }
    public function scopeByCategory($query, $category) { return $category ? $query->where('category', $category) : $query; }
}
