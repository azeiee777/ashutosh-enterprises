<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'contact_person',
        'mobile',
        'email',
        'gst',
        'address',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    // Relationships
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
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

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;
        return $query->where(function ($q) use ($search) {
            $q->where('company_name', 'like', "%{$search}%")
              ->orWhere('contact_person', 'like', "%{$search}%")
              ->orWhere('mobile', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getActiveSitesCountAttribute(): int
    {
        return $this->sites()->where('status', Status::ACTIVE)->count();
    }
}
