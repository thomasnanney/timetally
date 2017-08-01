<?php
Route::get('/reports', "ReportsController@index")->name('reports');
Route::post('/reports/getReport/{type}', "ReportsController@getReport");
Route::get('/reports/timeEntryReportPDF', "ReportsController@createTimeEntryReportPDF")->name('timeEntryReportPDF');
Route::get('/reports/timeEntryReportCSV', "ReportsController@downloadCSV")->name('payrollReportCSV');