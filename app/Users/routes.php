<?php
Route::get('/users', "UsersController@index")->name('users');
Route::post('/users/getAllClients', 'UsersController@postGetClientsByUser');
Route::post('/users/getAllProjects', 'UsersController@postGetAllProjectsByUser');