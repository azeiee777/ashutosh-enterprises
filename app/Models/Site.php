<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'site_name',
        'address',
        'supervisor_name',
        'start_date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'status' => Status::class,
        'start_date' => 'date',
    ];

    // Relationships
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function dailyLabourSupplies(): HasMany
    {
        return $this->hasMany(DailyLabourSupply::class);
    }

    public function paymentRecords(): HasMany
    {
        return $this->hasMany(PaymentRecord::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function scopeByClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;
        return $query->where(function ($q) use ($search) {
            $q->where('site_name', 'like', "%{$search}%")
              ->orWhere('supervisor_name', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        });
    }
}
