<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class UserType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
