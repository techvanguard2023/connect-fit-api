<?php

namespace App\Models\Lead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Lead\Lead;

class LeadVerification extends Model
{
    protected $fillable = [
        'lead_id',
        'code',
        'expires_at',
        'verified_at',
        'attempts',
        'ip_address'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function isValid(): bool
    {
        return $this->expires_at > now() 
            && is_null($this->verified_at) 
            && $this->attempts < 3;
    }

    public function markAsVerified(): void
    {
        $this->update(['verified_at' => now()]);
    }

    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }

    public static function generateCode(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}

