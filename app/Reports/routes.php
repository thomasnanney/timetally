<?php
Route::get('/reports', "ReportsController@index")->name('reports');
Route::post('/reports/getReport/{type}', "ReportsController@getReport");