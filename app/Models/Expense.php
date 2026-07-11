<?php

namespace App\Models;

use App\Enums\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'category',
        'amount',
        'vendor',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'category' => ExpenseCategory::class,
        'amount' => 'decimal:2',
    ];

    // Scopes
    public function scopeDateRange($query, $from, $to)
    {
        if ($from) $query->where('date', '>=', $from);
        if ($to) $query->where('date', '<=', $to);
        return $query;
    }

    public function scopeByCategory($query, $category)
    {
        return $category ? $query->where('category', $category) : $query;
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                     ->whereYear('date', now()->year);
    }
}
