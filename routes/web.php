<?php

Auth::routes();

Route::post('member/login', 'Auth\Custom\LoginController@login');
Route::post('member/register', 'Auth\Custom\RegisterController@store');

Route::get('/backend', 'BackendController@index')->name('backend.index');

Route::resource('members', 'MembersController');

Route::get('conversations/{conversation}/session/{sessionId}', 'ConversationsController@show')
    ->name('conversations.show');

Route::get('users/list', 'UsersController@getUsers')->name('users.list');
Route::resource('users', 'UsersController');

Route::get('user-roles', 'UserRolesController@index')->name('user-roles');
Route::post('users/{user}/roles/{role}', 'UserRolesController@assign');
Route::delete('users/{user}/roles/{role}', 'UserRolesController@remove');

Route::get('change-password', 'Auth\ChangePasswordController@changePassword')->name('change_password');
Route::patch('change-password', 'Auth\ChangePasswordController@updatePassword');

Route::get('/admin', 'AdminController@index');
Route::namespace('Admin')->group(function () {
    Route::get('admin/events', 'EventsController@index')->name('admin.events.index');
    Route::get('admin/events/create', 'EventsController@create')->name('admin.events.create');
    Route::post('admin/events', 'EventsController@store')->name('admin.events.store');
    Route::post('admin/events/filter', 'EventsController@filter')->name('admin.events.filter');
    Route::post('admin/events/{event}/delete', 'EventsController@destroy')->name('admin.events.destroy');
    Route::get('admin/events/{event}/preview', 'EventsController@preview')->name('admin.events.preview');
    Route::get('admin/events/{event}', 'EventsController@show')->name('admin.events.show');
    Route::get('admin/events/{event}/edit', 'EventsController@edit')->name('admin.events.edit');
    Route::patch('admin/events/{event}/update', 'EventsController@update')->name('admin.events.update');
    Route::post('admin/events/{event}/publish', 'EventsController@publish')->name('admin.events.publish');

    Route::get('admin/events/{event}/attendees/create', 'Event\AttendeesController@create')->name('admin.events.attendees.create');
    Route::post('admin/events/{event}/attendees', 'Event\AttendeesController@store')->name('admin.events.attendees.store');
    Route::post('admin/events/{event}/attendees/{event_attendee}/delete', 'Event\AttendeesController@destroy')->name('admin.events.attendees.destroy');

    Route::get('admin/get-members', 'MembersController@getMembers')->name('admin.get-members');

    Route::get('admin/sermon-speakers/list', 'Sermon\SpeakersController@getSpeakers');
    Route::post('admin/sermon-speakers', 'Sermon\SpeakersController@store');

//    /admin/series/' +  data.id + '/sermons/create

    Route::get('admin/series/{series}/sermons/create', 'Series\SermonsController@create');
    Route::post('admin/series/{series}/sermons', 'Series\SermonsController@store');

    Route::get('admin/series/create', 'SeriesController@create');
    Route::get('admin/series/{series}/preview', 'SeriesController@preview')->name('admin.series.preview');
    Route::get('admin/series', 'SeriesController@index')->name('admin.series.index');
    Route::get('admin/series/{series}', 'SeriesController@show')->name('admin.series.show');
    Route::post('admin/series/filter', 'SeriesController@filter');
    Route::get('admin/series/{series}/edit', 'SeriesController@edit')->name('admin.series.edit');
    Route::patch('admin/series/{series}/update', 'SeriesController@update')->name('admin.series.update');
    Route::post('admin/series', 'SeriesController@store');
    Route::post('admin/series/{series}/delete', 'SeriesController@destroy')->name('admin.series.destroy');
    Route::post('admin/series/{series}/publish', 'SeriesController@publish')->name('admin.series.publish');

    Route::get('admin/conversations', 'ChatController@index')->name('admin.conversations.index');
});