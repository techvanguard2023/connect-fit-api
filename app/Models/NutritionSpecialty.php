<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutritionSpecialty extends Model
{
    //

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'nutrition_professional_specialty');
    }
}
