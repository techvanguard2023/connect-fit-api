<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Para apps API-first, normalmente não redireciona;
     * apenas retorna 401 JSON quando não autenticado.
     */
    protected function redirectTo($request): ?string
    {
        return null; // sem redirect (API)
        // Se for app com páginas web, você poderia:
        // if (!$request->expectsJson()) return route('login');
    }
}
