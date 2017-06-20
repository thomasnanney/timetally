<?php
Route::get('/projects', "ProjectsController@index")->name('projects');
Route::get('/projects/add', "ProjectsController@getAdd")->name('addProject');
Route::get('/projects/view/{project}', "ProjectsController@getView")->name('viewProject');