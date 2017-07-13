<?php
Route::get('/timer', "TimerController@index")->name('timer');
Route::post('/timer/create', "TimerController@postCreate");