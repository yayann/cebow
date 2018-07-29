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

Route::get('/', 'HomeController@welcome');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Auth::routes();


Route::group(['middelware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::post('/subscribe', 'SubscriberController@store')->name('subscriber.store');
    Route::delete('/subscribe/{id}', 'SubscriberController@destroy')->name('subscriber.destroy');
});
