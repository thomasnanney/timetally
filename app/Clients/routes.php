<?php
Route::get('/clients', "ClientsController@index")->name('clients');
Route::get('/clients/create', 'ClientsController@getCreate');
Route::post('/clients/create', 'ClientsController@postCreate');
Route::get('/clients/edit/{client}', 'ClientsController@getEdit');
Route::post('/clients/edit/{client}', 'ClientsController@postEdit');
Route::delete('/clients/delete/{client}', "ClientsController@deleteClient");
Route::post('clients/getProjects/{client}', "ClientsController@getProjectsByUsersWorkspaces");
