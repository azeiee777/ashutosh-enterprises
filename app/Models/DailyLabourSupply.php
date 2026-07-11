<?php

namespace App\Models;

use App\Enums\Shift;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyLabourSupply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'client_id',
        'site_id',
        'skilled_count',
        'semi_skilled_count',
        'unskilled_count',
        'other_count',
        'total_count',
        'shift',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'shift' => Shift::class,
        'skilled_count' => 'integer',
        'semi_skilled_count' => 'integer',
        'unskilled_count' => 'integer',
        'other_count' => 'integer',
        'total_count' => 'integer',
    ];

    // Relationships
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    // Auto-calculate total before saving
    protected static function booted(): void
    {
        static::saving(function (DailyLabourSupply $model) {
            $model->total_count = $model->skilled_count + $model->semi_skilled_count
                + $model->unskilled_count + $model->other_count;
        });
    }

    // Scopes
    public function scopeDateRange($query, $from, $to)
    {
        if ($from) $query->where('date', '>=', $from);
        if ($to) $query->where('date', '<=', $to);
        return $query;
    }

    public function scopeByClient($query, $clientId)
    {
        return $clientId ? $query->where('client_id', $clientId) : $query;
    }

    public function scopeBySite($query, $siteId)
    {
        return $siteId ? $query->where('site_id', $siteId) : $query;
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
