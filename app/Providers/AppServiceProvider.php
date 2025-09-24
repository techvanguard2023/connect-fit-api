<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();

        // Gera o link de reset apontando para o frontend
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            $frontend = config('app.frontend_url', env('FRONTEND_URL','http://localhost:8080'));
            return "{$frontend}/reset-password?token={$token}&email=" . urlencode($notifiable->email);
        });

        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $frontend = config('app.frontend_url', env('FRONTEND_URL','http://localhost:8080'));
            $url = "{$frontend}/reset-password?token={$token}&email=" . urlencode($notifiable->email);
            $expire = (int) config('auth.passwords.' . config('auth.defaults.passwords') . '.expire', 60);

            return (new MailMessage)
                ->subject('Redefinição de senha - ConectFit')
                ->markdown('emails.auth.reset-password', [
                    'url'    => $url,
                    'expire' => $expire,
                    'user'   => $notifiable,
                    'logoUrl' => asset('img/logo/logo_conect_fit_2.png'),
                ]);
        });
    }
}
