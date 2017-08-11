<?php
Route::get('/users', "UsersController@index")->name('users');
Route::post('/users/getAllClients', 'UsersController@postGetClientsByUser');
Route::post('/users/getAllProjects', 'UsersController@postGetAllProjectsByUser');
Route::post('/users/getAllWorkspaces', 'UsersController@postGetAllWorkspacesByUser');
Route::post('/users/getAllTimeEntries', 'UsersController@postGetAllTimeEntriesByUser');
Route::post('/users/getCurrentWorkspace', 'UsersController@postGetCurrentWorkspaceByUser');
Route::post('/users/makeWorkspaceActive/{workspace}', 'UsersController@postMakeWorkspaceActive');