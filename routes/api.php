<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\TelegramWebhookController;

Route::post('/telegram/webhook', [TelegramWebhookController::class, 'handle']);
