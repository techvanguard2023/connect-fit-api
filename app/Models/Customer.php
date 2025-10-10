<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'user_type_id',
        'stripe_customer_id',
        'name',
        'email',
        'phone',
        'password',
        'profile_picture',
        'cover_photo',
        'email_verified_at',
        'opt_in',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    // Um usuário tem muitas assinaturas
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Assinatura atual (ativa e com maior end_date)
    public function currentSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->latestOfMany('end_date'); // pega a de maior end_date
    }

    public function nutritionSpecialties()
    {
        return $this->belongsToMany(NutritionSpecialty::class, 'nutrition_professional_specialty');
    }

    public function personalTrainerInfo()
    {
        return $this->hasOne(PersonalTrainerInfo::class);
    }

    public function trainingFocuses()
    {
        // tabela pivot, foreignPivotKey (customer_id), relatedPivotKey (training_focus_id)
        return $this->belongsToMany(\App\Models\TrainingFocus::class, 'customer_training_focus', 'customer_id', 'training_focus_id');
    }

}
