<?php
Route::get('/workspaces', "WorkspacesController@index")->name('workspaces');
Route::post('/workspaces/create', "WorkspacesController@postCreate");
Route::get('/workspaces/edit/{workspace}', "WorkspacesController@getEdit");
Route::post('/workspaces/edit/{workspace}', "WorkspacesController@postEdit");
Route::delete('/workspaces/delete/{workspace}', "WorkspacesController@deleteWorkspace");