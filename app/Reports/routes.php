<?php
Route::get('/reports', "ReportsController@index")->name('reports');
Route::post('/reports/getReport/{type}', "ReportsController@getReport");
Route::post('/reports/getReportPDF', "ReportsController@createReportPDF")->name('createReportPDF');
Route::post('/reports/getReportXLS', "ReportsController@createReportXLS")->name('createReportXLS');
Route::post('/reports/getReportCSV', "ReportsController@createReportCSV")->name('createReportCSV');
Route::get('/reports/downloadReport/{fileName}', 'ReportsController@getDownloadReport');