<?php

use Illuminate\Support\Facades\Route;

// routes/web.php
use App\Events\Ping;
Route::get('/test-broadcast', function () {
    broadcast(new Ping('pong'));
    return 'ok';
});