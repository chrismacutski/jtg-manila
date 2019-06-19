<?php

Route::namespace('Chat')->group(function () {
    Route::get('chat', 'ChatController@index');

    Route::post('conversation/{sessionId}/chat', 'ChatController@store');

    Route::get('conversation/{sessionId}/website', 'ConversationController@show')
        ->name('chat.conversation.show');

    Route::post('{sessionId}/chatter', 'ChatterController@store')
        ->name('chat.chatter.store');
});
