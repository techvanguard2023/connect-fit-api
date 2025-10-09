<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class TrainingFocus extends Model
{
    //

     protected $table = 'training_focuses';

    protected $fillable = [
        'name',
    ];

    public function customers()
    {
        // tabela pivot, foreignPivotKey (training_focus_id), relatedPivotKey (customer_id)
        return $this->belongsToMany(Customer::class, 'customer_training_focus', 'training_focus_id', 'customer_id');
    }
}
