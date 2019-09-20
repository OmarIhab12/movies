<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');

Route::get('genres', 'Api\GenreController@index');
Route::get('genres/{id}', 'Api\GenreController@details');
Route::post('genres', 'Api\GenreController@create');
Route::put('genres/{id}', 'Api\GenreController@update');
Route::delete('genres/{id}', 'Api\GenreController@delete');

Route::get('actors', 'Api\ActorController@index');
Route::get('actors/{id}', 'Api\ActorController@details');
Route::post('actors', 'Api\ActorController@create');
Route::put('actors/{id}', 'Api\ActorController@update');
Route::delete('actors/{id}', 'Api\ActorController@delete');
