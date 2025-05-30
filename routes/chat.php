<?php

use App\Http\Controllers\RouteController;
use App\Http\Controllers\Chats\DiscussionController;
use App\Http\Controllers\Chats\MessageController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:user'])->prefix('creator-chat')->group(function () {
    Route::get('/', [RouteController::class, 'chats'])->name('chats');
    Route::resource('discussions', DiscussionController::class);
    Route::resource('messages', MessageController::class);
});

// Broadcast::channel('chat', function ($user) {
//     return auth()->check();
// });
