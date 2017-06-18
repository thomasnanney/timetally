<?php
Route::get('clients', "ClientsController@index")->name('clients');
Route::post('clients', "ClientsController@store");
//Route::put('/clients', "ClientsController@index")->name('clients');
//Route::patch('/clients', "ClientsController@index")->name('clients');
//Route::delete('/clients', "ClientsController@index")->name('clients');