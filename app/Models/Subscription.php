<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\Plan;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'plan_id',
        'stripe_subscription_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'status'     => 'string',
    ];

    // Relacionamentos
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Escopo útil para pegar assinaturas ativas "hoje"
    public function scopeActive($query)
    {
        return $query
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    // Atributo conveniente
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active'
            && $this->start_date->lte(now())
            && $this->end_date->gte(now());
    }
}
