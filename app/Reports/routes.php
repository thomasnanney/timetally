<?php
Route::get('/reports', "ReportsController@index")->name('timer');
Route::post('/getReport/{type}', "ReportsController@getReport");