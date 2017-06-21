<?php
Route::get('/projects', "ProjectsController@index")->name('projects');
Route::post('/projects/views/{project}', "ProjectsController@postUpdateScope")->name('postUpdateScope');
Route::post('/projects/views/{project}', "ProjectsController@postUpdateProjectedRevenue")->name('postUpdateProjectedRevenue');
Route::post('/projects/views/{project}', "ProjectsController@postUpdateBillableRate")->name('postUpdateBillableRate');