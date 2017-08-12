<?php
Route::get('/reports', "ReportsController@index")->name('reports')->middleware('permissions');
Route::post('/reports/getReport/{type}', "ReportsController@getReport");
Route::post('/reports/getBarData', "ReportsController@getBarData");
Route::post('/reports/getReportPDF', "ReportsController@createReportPDF")->name('createReportPDF')->middleware('permissions');
Route::post('/reports/getReportXLS', "ReportsController@createReportXLS")->name('createReportXLS')->middleware('permissions');
Route::post('/reports/getReportCSV', "ReportsController@createReportCSV")->name('createReportCSV')->middleware('permissions');
Route::get('/reports/downloadReport/{fileName}', 'ReportsController@getDownloadReport')->middleware('permissions');