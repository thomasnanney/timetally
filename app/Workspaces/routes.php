<?php
Route::get('/workspaces', "WorkspacesController@index")->name('workspaces');
Route::post('/workspaces/create', "WorkspacesController@postCreate");
Route::get('/workspaces/edit/{workspace}', "WorkspacesController@getEdit");
Route::post('/workspaces/edit/{workspace}', "WorkspacesController@postEdit");
Route::delete('/workspaces/delete/{workspace}', "WorkspacesController@deleteWorkspace");
Route::post('/workspaces/getAllUsers/{workspace?}', "WorkspacesController@getAllUsers");
Route::post('/workspaces/getAllProjects/{workspace?}', "WorkspacesController@getAllProjects");
Route::post('/workspaces/getAllClients/{workspace?}', "WorkspacesController@getAllClients");
Route::get('/workspaces/invite/{workspace}', 'WorkspaceInviteController@getInvite');
Route::post('workspaces/invite/{workspace}', 'WorkspaceInviteController@postInvite');