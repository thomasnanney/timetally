<?php
Route::get('/clients', "ClientsController@index")->name('clients');
Route::get('/clients/add', "ClientsController@getAdd")->name('addClient');
Route::get('/clients/view/{client}', "ClientsController@getView")->name('viewClient');