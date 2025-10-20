<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feature;
use App\Models\Subscription;

class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = ['name', 'description', 'price', 'period', 'is_free', 'popular', 'stripe_price_id'];


    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_plans')->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
