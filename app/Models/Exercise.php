<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class);
    }

    public function muscleGroup()
    {
        return $this->belongsTo(MuscleGroup::class);
    }
}
