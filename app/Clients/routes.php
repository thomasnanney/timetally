<?php
Route::get('/clients', "ClientsController@index")->name('clients');
Route::get('/clients/create', 'ClientsController@getCreate')->middleware('permissions');
Route::post('/clients/create', 'ClientsController@postCreate')->middleware('permissions');
Route::get('/clients/edit/{client}', 'ClientsController@getEdit')->middleware('permissions');
Route::post('/clients/edit/{client}', 'ClientsController@postEdit')->middleware('permissions');
Route::delete('/clients/delete/{client}', "ClientsController@deleteClient")->middleware('permissions');
Route::post('clients/getProjects/{client}', "ClientsController@getProjectsByUsersWorkspaces");
