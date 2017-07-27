<?php
Route::get('/reports', "ReportsController@index")->name('timer');
Route::get('/reports/timeEntryReportPDF', "ReportsController@createTimeEntryReportPDF")->name('timeEntryReportPDF');
Route::get('/reports/timeEntryReportCSV', "ReportsController@downloadCSV")->name('payrollReportCSV');