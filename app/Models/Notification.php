<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id', 'type', 'title', 'message', 'is_read', 'action_url'];
    protected $casts = ['is_read' => 'boolean'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function scopeUnread($query) { return $query->where('is_read', false); }
    public function scopeForUser($query, $userId) { return $query->where('user_id', $userId)->orWhereNull('user_id'); }
}
