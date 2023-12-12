<?php

use App\Http\Controllers\ChatMessageController;
use Illuminate\Support\Facades\Route;

Route::group([ 'prefix' => 'chats'], function () {
    Route::get('users/pull', [ChatMessageController::class, 'fetchAllUsers']);
    Route::get('my-contacts', [ChatMessageController::class, 'fetchAllUserContacts']);
    Route::get('get-my-messages/{chatKey}', [ChatMessageController::class, 'fetchUserContactMessages']);
    Route::post('add-to-contact/{userId}', [ChatMessageController::class, 'addUserToMyContact']);
    Route::post('{chatKey}/send', [ChatMessageController::class, 'sendMessageToUserContact']);
});
