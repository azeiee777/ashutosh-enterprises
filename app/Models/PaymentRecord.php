<?php

namespace App\Models;

use App\Enums\PaymentHead;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'client_id',
        'site_id',
        'payment_head',
        'amount',
        'payment_method',
        'paid_to',
        'description',
        'reference_number',
        'attachment_path',
    ];

    protected $casts = [
        'date' => 'date',
        'payment_head' => PaymentHead::class,
        'payment_method' => PaymentMethod::class,
        'amount' => 'decimal:2',
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

    public function scopeByHead($query, $head)
    {
        return $head ? $query->where('payment_head', $head) : $query;
    }
}
