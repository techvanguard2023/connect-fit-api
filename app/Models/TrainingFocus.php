<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class TrainingFocus extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'professional_training_focus');
    }
}
