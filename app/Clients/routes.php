<?php
Route::get('clients', "ClientsController@index")->name('clients');
//Route::get('clients/{id}', "ClientsController@find");
Route::post('clients', "ClientsController@createClient");
Route::put('/clients/{id}/update', "ClientsController@update");
//Route::patch('/clients', "ClientsController@index")->name('clients');
//Route::delete('/clients/{id}/delete', "ClientsController@delete");