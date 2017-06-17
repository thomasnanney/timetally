<?php
Route::get('/workspaces', "WorkspacesController@index")->name('workspaces');

Route::get('/workspaces/view/{workspace}', "WorkspacesController@getViewWorkspace")->name('viewWorkspace');