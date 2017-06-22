<?php
Route::get('/projects', "ProjectsController@index")->name('projects');
Route::post('/projects/edit/{project}', 'ProjectsController@postUpdate')->name('updateProject');
Route::get('/projects/edit/{project}', "ProjectsController@getView")->name('viewProject');
Route::post('/projects/create', 'ProjectsController@postCreate');
Route::get('/projects/create', 'ProjectsController@getCreate');
Route::delete('/projects/delete/{project}', 'ProjectsController@deleteProject');
