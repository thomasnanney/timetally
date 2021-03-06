<?php
Route::get('/workspaces', "WorkspacesController@index")->name('workspaces');
Route::post('/workspaces/create', "WorkspacesController@postCreate");
Route::get('/workspaces/edit/{workspace}', "WorkspacesController@getEdit")->middleware('permissions');
Route::post('/workspaces/edit/{workspace}', "WorkspacesController@postEdit")->middleware('permissions');
Route::delete('/workspaces/delete/{workspace}', "WorkspacesController@deleteWorkspace")->middleware('permissions');
Route::post('/workspaces/leave/{workspace}', "WorkspacesController@leaveWorkspace");
Route::get('/workspaces/view/{workspace}', 'WorkspacesController@getEdit');
Route::post('/workspaces/getAllUsers/{workspace?}', "WorkspacesController@getAllUsers");
Route::post('/workspaces/getAllProjects/{workspace?}', "WorkspacesController@getAllProjects");
Route::post('/workspaces/getAllClients/{workspace?}', "WorkspacesController@getAllClients");
Route::post('/workspaces/inviteUsers/{workspace}', 'WorkspaceInviteController@postInvite')->middleware('permissions');
Route::post('workspaces/addAdmin/{user}', 'WorkspacesController@addAdmin')->middleware('permissions');
Route::post('workspaces/removeAdmin/{user}', 'WorkspacesController@removeAdmin')->middleware('permissions');
Route::get('/confirmInvitation/{token}', 'WorkspaceInviteController@getConfirmInvitation');
