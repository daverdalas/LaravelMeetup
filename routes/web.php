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

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');

Route::namespace('Admin')
    ->middleware(['auth', 'auth.admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::resource('users', 'UserController');
    });

Route::get('users-bad-json', 'JsonController@badIndex');

Route::get('users-good-json', 'JsonController@goodIndex');

Route::get('users-good-json-resources', 'JsonController@goodIndexResources');

Route::get('test-app-state', function () {
    $app = app();
    if (isset($app['test'])) {
        $app['test'] += 2;
    } else {
        $app['test'] = 2;
    }
    return response()->json(['test' => $app['test']]);
});