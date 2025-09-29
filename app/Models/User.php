<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Subscription;
use App\Models\NutritionSpecialty;
use App\Models\TrainingFocus;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_type_id',
        'stripe_customer_id',
        'name',
        'email',
        'phone',
        'password',
        'profile_picture',
        'email_verified_at',
        'opt_in',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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

    public function trainingFocuses()
    {
        return $this->belongsToMany(TrainingFocus::class, 'professional_training_focus');
    }

}
