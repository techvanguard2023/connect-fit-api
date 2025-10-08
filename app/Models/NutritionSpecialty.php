<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class NutritionSpecialty extends Model
{
    //

    protected $fillable = [
        'name',
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'nutrition_professional_specialty');
    }
}
