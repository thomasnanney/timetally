<?php
Route::get('/projects', "ProjectsController@index")->name('projects');
Route::post('/projects/edit/{project}', 'ProjectsController@postEdit')->middleware('permissions');
Route::get('/projects/edit/{project}', "ProjectsController@getEdit")->middleware('permissions');
Route::post('/projects/create', 'ProjectsController@postCreate')->middleware('permissions');
Route::get('/projects/create', 'ProjectsController@getCreate')->middleware('permissions');
Route::post('/projects/delete/{project}', 'ProjectsController@deleteProject')->middleware('permissions');
Route::post('/projects/getUsers/{project}', 'ProjectsController@getUsers');
Route::post('/projects/{project}/addUser/{user}', 'ProjectsController@addUser')->middleware('permissions');
Route::post('/projects/{project}/removeUser/{user}', 'ProjectsController@removeUser')->middleware('permissions');
