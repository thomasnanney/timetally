<?php
Route::get('/clients', "ClientsController@index")->name('clients');
Route::post('/clients', "ClientsController@createClient");
Route::put('/clients/edit/{id}', "ClientsController@editClient");
Route::delete('/clients/delete/{id}', "ClientsController@deleteClient");
