<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuscleGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'color',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
