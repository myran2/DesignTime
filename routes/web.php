<?php

// PUBLIC HOMEPAGE ROUTE
Route::view('/', 'welcome');

// INSTANTIATE AUTH ROUTING AND ESTABLISH LOGOUT ROUTE
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

// USER HOMEPAGE ROUTE
//Route::get('/home', 'HomeController@index');
Route::redirect('/home', '/tasks');
Route::redirect('/', '/tasks');

Route::resource('/tasks', 'TasksController');

Route::resource('/projects', 'ProjectsController');
