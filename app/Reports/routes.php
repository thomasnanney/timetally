<?php
Route::get('/reports', "ReportsController@index")->name('reports');
Route::post('/reports/getReport/{type}', "ReportsController@getReport");
Route::get('/reports/getReportPDF', "ReportsController@createReportPDF")->name('createReportPDF');
Route::get('/reports/getReportXLS', "ReportsController@createReportXLS")->name('createReportXLS');
Route::get('/reports/getReportCSV', "ReportsController@createReportCSV")->name('createReportCSV');