<?php
Route::get('/projects', "ProjectsController@index")->name('projects');
Route::post('/projects/edit/{project}', 'ProjectsController@postEdit');
Route::get('/projects/edit/{project}', "ProjectsController@getEdit");
Route::post('/projects/create', 'ProjectsController@postCreate');
Route::get('/projects/create', 'ProjectsController@getCreate');
Route::post('/projects/delete/{project}', 'ProjectsController@deleteProject');
Route::post('/projects/getUsers/{project}', 'ProjectsController@getUsers');
Route::post('projects/{project}/removeUser/{user}', 'ProjectsController@removeUser');
Route::post('projects/{project}/addUser/{user}', 'ProjectsController@addUser');