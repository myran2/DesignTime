<?php
use Spatie\Honeypot\ProtectAgainstSpam;

// PUBLIC HOMEPAGE ROUTE
Route::view('/', 'welcome');

// INSTANTIATE AUTH ROUTING AND ESTABLISH LOGOUT ROUTE
// wrap Auth routes in honeypot spam protection middleware
Route::middleware(ProtectAgainstSpam::class)->group(function() {
    Auth::routes();
});
Route::get('/logout', 'Auth\LoginController@logout');

// USER HOMEPAGE ROUTE
//Route::get('/home', 'HomeController@index');
Route::redirect('/home', '/tasks');
Route::redirect('/', '/tasks');

Route::post('/tasks/order', 'TasksController@setOrder');

Route::resource('/tasks', 'TasksController');

Route::resource('/projects', 'ProjectsController');
