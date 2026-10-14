<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameController;

Route::get('/ping', fn () => response()->json([
    'message' => 'pong',
    'time'    => now()->toIso8601String(),
    'student' => config('lab.slug'),
]));

Route::name('api.')->group(function () {
    Route::apiResource('games', GameController::class);
});
