<?php
Route::get('/reports', "ReportsController@index")->name('timer');
Route::get('/reports/payrollReport', "ReportsController@createPayrollReport")->name('payrollReport');