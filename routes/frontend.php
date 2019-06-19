<?php

Route::namespace('Frontend')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/contact', 'ContactController@index')->name('frontend.contact');
});

Route::namespace('Frontend\About')->prefix('about')->group(function () {
    Route::get('/vision', 'VisionController@index')->name('frontend.about.vision');
    Route::get('/leadership', 'LeadershipController@index')->name('frontend.about.leadership');
    Route::get('/history', 'HistoryController@index')->name('frontend.about.history');
    Route::get('/senior-pastors', 'SeniorPastorsController@index')->name('frontend.about.senior-pastors');
    Route::get('/ministries', 'MinistriesController@index')->name('frontend.about.ministries');
    Route::get('/others', 'OthersController@index')->name('frontend.about.others');
    Route::get('/real-made-teachings', 'RealMadeTeachingsController@index')->name('frontend.about.real-made-teachings');
});

Route::resource('series', 'SeriesController');
Route::post('series/filter', 'SeriesController@filter')->name('series.filter');
Route::resource('sermons', 'SermonsController');
Route::post('sermons/filter', 'SermonsController@filter')->name('sermons.filter');
//Route::get('series', 'SeriesController@index')->name('series.index');
//Route::get('series/{series}', 'SeriesController@show')->name('series.show');
//Route::get('sermons', 'SermonsController@index')->name('sermons.index');
//Route::get('sermons/{sermon}', 'SermonsController@show')->name('sermons.show');

Route::get('events', 'EventsController@index')->name('events.index');
Route::get('events/{event}', 'EventsController@show')->name('events.show');
Route::post('events/filter', 'EventsController@filter')->name('events.filter');
