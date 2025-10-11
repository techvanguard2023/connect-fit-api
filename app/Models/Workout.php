<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'customer_id',
        'title',
        'description',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class);
    }

    


}
