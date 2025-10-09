<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTrainingFocus extends Model
{
    protected $table = 'customer_training_focus';

    protected $fillable = [
        'customer_id',
        'training_focus_id',
    ];
}
