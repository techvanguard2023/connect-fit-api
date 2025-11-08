<?php

namespace App\Models\Lead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Lead\LeadVerification;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'type',
        'status',
        'ip_address',
        'opt_in'
    ];

    protected $casts = [
        'opt_in' => 'boolean',
    ];

    public function verifications(): HasMany
    {
        return $this->hasMany(LeadVerification::class);
    }

    public function getActiveVerification(): ?LeadVerification
    {
        return $this->verifications()
            ->where('expires_at', '>', now())
            ->whereNull('verified_at')
            ->where('attempts', '<', 3)
            ->first();
    }

    public function markAsVerified(): void
    {
        $this->update(['status' => 'verified']);
    }
}
