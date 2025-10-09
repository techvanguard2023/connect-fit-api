<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalTrainerInfo extends Model
{
    protected $table = 'personal_trainer_infos';

    protected $fillable = [
        'customer_id',
        'certifications',
        'experience_years',
    ];

    protected $casts = [
        'certifications' => 'json',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
