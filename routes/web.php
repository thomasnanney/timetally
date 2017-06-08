<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/timer', "TimerController@index")->name('timer');

Route::get('/reports', "ReportsController@index")->name('timer');

Route::get('/clients', "ClientsController@index")->name('clients');

Route::get('/projects', "ProjectsController@index")->name('projects');

Route::get('/users', "UsersController@index")->name('users');

Route::get('/workspaces', "WorkspacesController@index")->name('workspaces');
