<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/auth/login', ['uses' => 'Auth\GithubAuthController@login']);
Route::get('/auth/callback', ['uses' => 'Auth\GithubAuthController@callback']);
Route::get('/{index?}', ['middleware' => 'auth', 'uses' => 'MainController@index']);
