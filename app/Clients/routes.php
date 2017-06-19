<?php
Route::get('clients', "ClientsController@index")->name('clients');
//Route::get('clients/{id}', "ClientsController@find");
Route::post('clients', "ClientsController@createClient");
Route::put('/clients/view/{client}', "ClientsController@updateClient")-name('viewClient');
//Route::patch('/clients', "ClientsController@index")->name('clients');
Route::delete('/clients/delete/{client}', "ClientsController@deleteClient");