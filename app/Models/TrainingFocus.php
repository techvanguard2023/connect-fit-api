<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingFocus extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'professional_training_focus');
    }
}
